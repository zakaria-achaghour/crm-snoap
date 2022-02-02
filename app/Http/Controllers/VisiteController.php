<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Doctor;
use App\Models\Grossiste;
use App\Models\Plv;
use App\Models\Product;
use App\Models\User;
use App\Models\UserResponsable;
use App\Models\Visite;
use App\Repositories\NetworkRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RegionRepository;
use App\Repositories\UgRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Rupture;

class VisiteController extends Controller
{
    
    private $ugRepository;
    private $productRepository;
    private $networkRepository;
    private $regionRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository,RegionRepository $regionRepository ,UgRepository $ugRepository ,ProductRepository $productRepository,NetworkRepository $networkRepository)
    {
        $this->middleware('auth');
       
        $this->ugRepository = $ugRepository;
        $this->productRepository = $productRepository;
        $this->networkRepository = $networkRepository;
        $this->regionRepository = $regionRepository;
        $this->userRepository = $userRepository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());
           $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
            return view('visites.pharmacy.index', ['delegues' => $delegues]);


        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
            return view('visites.pharmacy.index', ['delegues' => $delegues]);


        }
        else{
            return view('visites.pharmacy.index_delegue');
        }
    }

    public function visiteUser($id)
    {
        $visites = DB::table('visites')
            ->join('clients', 'clients.id', 'visites.client_id')
            ->select('clients.nom', 'clients.adresse', 'clients.is', 'clients.bloque', 'visites.id', 'visites.user_id', 'visites.created_at', 'visites.fin')
            ->where('visites.user_id', $id)
            ->orderBy('id', 'DESC')
            ->limit('100')
            ->get();

            
        //  dd($visites);
        return view('visites.pharmacy.visite', ['visites' => $visites]);
    }

    public function recherche($de, $a, $user)
    {
        $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $visites = DB::Table('visites')
            ->join('clients', 'clients.id', 'visites.client_id')
            ->select('visites.*', 'clients.adresse', 'clients.nom', 'clients.is', 'clients.bloque', 'visites.fin')
            ->where('visites.user_id', $user)
            ->whereBetween('visites.created_at', [$de, $a])
            ->orderBy('visites.id', 'DESC')
            ->get();

        return view('visites.pharmacy.visite', ['visites' => $visites]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($client, $planning)
    {
        $visite_id = DB::table('plannings')->where('id', $planning)->value('visite_id');
       // $ug_id = DB::table('clients')->where('id', $client)->value('ug_id');
        $numUg = DB::table('clients')->where('id', $client)->value('ugmc');

   
        if ($visite_id == NULL) {
            $client = Client::select('id', 'nom', 'motif')->where('id', $client)->first();
          //  $produits = Product::all();
            $medecins = Doctor::join('specialties', 'specialties.id','doctors.specialty_id')->select('doctors.id','name','adresse', 'specialties.designation')->where('ug_mc', $numUg)->orderBy('name')->get();
            
            return view('visites.pharmacy.create', ['client' => $client,  'planning' => $planning, 'medecins' => $medecins]);
        } else {

            return redirect()->route('visites.edit.pharmacy', ['visite_id' => $visite_id]);
        }
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $visite_id = DB::table('plannings')->where('id', $request->planning_id)->value('visite_id');

        if ($visite_id != NULL) {
            return redirect()->route('visitesEdit', ['visite_id' => $visite_id]);
        } else {

            //  save viste remmeber
            $visite = new Visite();
            //$visite->date_visite = new Date();
            $visite->type_VD = $request->type_vd;
            $visite->client_id = $request->clientId;
            $visite->user_id = Auth::id();

            $visite->type_enq_ref = $request->type_enq_ref;
            $visite->type_enq_rp = $request->type_enq_rp;
            $visite->step = 1;
            if ($request->medecin) {
                $visite->step = 0;
            }
            
            $visite->save();
            if ($request->medecin) {
                DB::table('visite_doctor_enquet')->insert([
                    'visite_id' =>  $visite->id,
                    'doctor_id' => $request->medecin,
                    'created_at' => Date::now(),
                    'updated_at' => Date::now(),
                ]);
            }

            //$visite->doctors()->attach($request->medecin);

            DB::table('plannings')->where('id', $request->planning_id)->update(['done' => 1, 'visite_id' => $visite->id]);
            DB::table('clients')->where('id', $request->clientId)->update(['reserved' => 0]);

            return redirect()->route('visites.edit.pharmacy', ['visite_id' => $visite->id]);
        }
    }

    public function DisplayProduct($visite_id)
    {
        $visites = Visite::find($visite_id);
        $visites->step = 1;
        $visites->save();
        $users=[];
        array_push($users,Auth::id());
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $productIds = $this->productRepository->productIdsByVisitePharmacy($visite_id);
        $products = $this->productRepository->productsByNetworksPharmacyDoctors($networks, $visites->client_id,$productIds);

        return view('visites.pharmacy._form_products', ['produits' => $products]);
    }

    public function DisplayDoctor($visite_id, $doctor_id)
    {
       
        $productIds = $this->productRepository->productIdsByVisitePharmacyDoctor($visite_id);

        $users=[];
        array_push($users,Auth::id());
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $products = $this->productRepository->productsByNetworksPharmacyDoctors($networks, $doctor_id,$productIds);

        $doctor = Doctor::find($doctor_id);

        return view('visites.pharmacy._form_doctor', ['produits' => $products, 'doctor' => $doctor]);
    }

    public function product(Request $request)
    {
        $other_doctors = $request->medecinsID;
        $visite = Visite::find($request->visiteId);

        $product = Product::find($request->productID);

        $visite->products()->attach($product, [
            'qte' => (int) $request->qteProduct,
            'miseEnPlace' => (int)$request->misenplace
        ]);

        if ($other_doctors!=0){

            foreach($other_doctors as $other_doctor){
                DB::table('visite_product_other_doctor')->insert([
                            'product_id' =>  $request->productID,
                            'visite_id' =>  $request->visiteId,
                            'doctor_id' => $other_doctor,
                            'created_at' => Date::now(),
                            'updated_at' => Date::now(),
                        ]);
            }

        }

        return redirect()->route('visites.productTable.pharmacy', ['id'=>$request->visiteId]);
    }

    public function doctorOrdonance(Request $request) {
       
         DB::table('visite_doctor_enquet')
              ->where('visite_id',$request->visiteId)
              ->where('doctor_id', $request->doctorId)
              ->update(['nb_ordonance' => $request->nbOrdonance]);
            
    }

    public function doctor(Request $request)
    {
        $visite = Visite::find($request->visiteId);
        $product = Product::find($request->productID);
        $visite->productsDoctors()->attach($product, [
            'qte' => (int) $request->qteProduct,
            'miseEnPlace' => (int)$request->misenplace
        ]);
        
        
        $products = DB::table('visite_product_doctor')
            ->join('products', 'products.id', 'visite_product_doctor.product_id')

            ->select('products.designation', 'products.id as product_id', 'visite_product_doctor.miseEnPlace', 'visite_product_doctor.qte', 'visite_product_doctor.id')

            ->where('visite_product_doctor.visite_id', $request->visiteId)
            ->get();

      

        return view('visites.pharmacy.table_visite_product_doctor', ['products' => $products]);
    }

    public function productTable($id)
    {
        $products = DB::table('visite_product')
            ->join('products', 'products.id', 'visite_product.product_id')

            ->select('products.designation', 'products.id as product_id', 'visite_product.miseEnPlace', 'visite_product.qte', 'visite_product.id')

            ->where('visite_product.visite_id', $id)
            ->get();

        $product_doctors = DB::table('products')
            ->join('visite_product_other_doctor', 'products.id', 'visite_product_other_doctor.product_id')

            ->select('products.designation', 'products.id as product_id', 
            DB::raw("(select STRING_AGG(doctors.name, ',') as medecins from visite_product_other_doctor, doctors  
            where doctors.id=visite_product_other_doctor.doctor_id and visite_product_other_doctor.product_id=products.id and visite_product_other_doctor.visite_id=".$id." group by product_id)  as medecins"))
            ->where('visite_product_other_doctor.visite_id', $id)
            ->groupBy('products.id','products.designation')
            ->get();

        return view('visites.pharmacy.table_visite_product', ['products' => $products, 'product_doctors' => $product_doctors]);
    }

    public function productDoctorTable($id)
    {
        $products = DB::table('visite_product_doctor')
            ->join('products', 'products.id', 'visite_product_doctor.product_id')

            ->select('products.designation', 'products.id as product_id', 'visite_product_doctor.miseEnPlace', 'visite_product_doctor.qte', 'visite_product_doctor.id')

            ->where('visite_product_doctor.visite_id', $id)
            ->get();

    


        return view('visites.pharmacy.table_visite_product_doctor', ['products' => $products]);
    }

    public function productDestroy($id)
    {

        $visite_id = DB::table('visite_product')->where('id', $id)->value('visite_id');
        $product_id = DB::table('visite_product')->where('id', $id)->value('product_id');

        DB::table('visite_product_other_doctor')->where('visite_id', $visite_id)->where('product_id', $product_id)->delete();
        DB::table('visite_product')->where('id', $id)->delete();

        
        return redirect()->route('visites.productTable.pharmacy', ['id'=>$visite_id]);
    }

    public function productDoctorDestroy($id)
    {

        $visite_id = DB::table('visite_product_doctor')->where('id', $id)->value('visite_id');
        DB::table('visite_product_doctor')->where('id', $id)->delete();

        $products = DB::table('visite_product_doctor')
            ->join('products', 'products.id', 'visite_product_doctor.product_id')
            ->select('products.designation', 'products.id as product_id', 'visite_product_doctor.miseEnPlace', 'visite_product_doctor.qte', 'visite_product_doctor.id')
            ->where('visite_product_doctor.visite_id', $visite_id)
            ->get();



        return view('visites.pharmacy.table_visite_product_doctor', ['products' => $products]);
    }

    public function rupture($visite)
    {

        $visites = Visite::find($visite);
        if ($visites->step == 1) {
            $visites->step = 2;
            $visites->save();
        }
        

        $productIDS = $this->productRepository->productRuptureIdsPharmacy($visite);
        //$networks = $this->networkRepository->getNetworksIdsByUser(Auth::id());
      $products =   Product::select('products.id','products.designation' )
                    ->whereNotIn('products.id', $productIDS)
                    ->where('products.statut', true)
                      ->groupBy('products.id','products.designation')
                    ->get();
        //$products = $this->productRepository->productByNetwork($productIDS,$networks);

        return view('visites.pharmacy._form_rupture', ['produits' => $products]);
    }

    public function storeRupture(Request $request)
    {

        //dd($request->all());
        if($request->autre==1){
            $request->product_id=null;
        }
        DB::table('ruptures')->insert( ['visite_id' => $request->visiteId, 'product_id' => $request->product_id, 'product' => $request->product,'autre' => $request->autre,'created_at' => Carbon::now()]);
        $rupture =  DB::table('ruptures')->where('visite_id',$request->visiteId)->where('product_id',$request->product_id)->value('id');
     
        if($request->autre!=1){

            if($request->grossisteId!='0')
            {
                foreach ($request->grossisteId as $key => $value) {
                    // dd($value .'   '. $key);
                    DB::table('rupture_grossiste')->insert(["rupture_id"=>$rupture,"grossiste_id"=>$value,"created_at" => Carbon::now()]);
            
                }
            }
        }
   
        return redirect()->route('visites.ruptureTable.pharmacy',$request->visiteId);
    }

    public function ruptureTable($id)
    {
         $products = DB::table('ruptures')

        ->select(
            (DB::raw('(select designation from products where products.id = product_id) as designation' ) ),
            (DB::raw("(select  STRING_AGG(grossistes.designation, ',') from grossistes,rupture_grossiste where ruptures.id = rupture_grossiste.rupture_id and rupture_grossiste.grossiste_id = grossistes.id  group by rupture_id ) as grossistes" ) ),

             'ruptures.product_id as product_id', 'ruptures.product', 'ruptures.autre', 'ruptures.id')
        ->where('ruptures.visite_id', $id)
        ->get();
        return view('visites.pharmacy.table_visite_rupture', ['products' => $products]);
    }

    public function ruptureDestroy($id){
        $visite_id = DB::table('ruptures')->where('id', $id)->value('visite_id');
    
        DB::table('ruptures')->where('id', $id)->delete();
        DB::table('rupture_grossiste')->where('rupture_id', $id)->delete();


        return redirect()->route('visites.ruptureTable.pharmacy', $visite_id);
    }

    public function ruptureVisite(Request $request)
    {
        $visite = Visite::find($request->visiteId);
        $visite->step = 3;
        $visite->save();

        $commande = new Commande();
        $commande->visite_id = $request->visiteId;
        $commande->commande = $request->commande;
        $commande->pack = $request->pack;
        $commande->ug = $request->commande_ug;
        $commande->remise = $request->commande_remise;

        if ($request->commande == 1) {

            $commande->save();
        }

        return redirect()->route('visites.duo.pharmacy', ['visite' => $request->visiteId]);
    }

  
    public function commande($visite)
    {

        $visites = Visite::find($visite);
        if ($visites->step == 2) {
            $visites->step = 3;
            $visites->save();
        }

        $commande = [];

        $commande = DB::table('commandes')
            ->select('commande', 'pack', 'ug', 'remise')
            ->where('visite_id', $visite)->first();
        return view('visites.pharmacy._form_commande', ['commande' => $commande]);
    }

    public function commandeVisite(Request $request)
    {
        
        $visite = Visite::find($request->visiteId);
        $visite->step = 4;
        $visite->save();

        $commande = new Commande();
        $commande->visite_id = $request->visiteId;
        $commande->commande = $request->commande;
        $commande->pack = $request->pack;
        $commande->ug = $request->commande_ug;
        $commande->remise = $request->commande_remise;

        if ($request->commande == 1) {

            $commande->save();
        }

        return redirect()->route('visites.duo.pharmacy', ['visite' => $request->visiteId]);
    }

    public function duo($visite)
    {

        $visites = Visite::find($visite);
        if ($visites->step == 3) {
            $visites->step = 4;
            $visites->save();
        }
        $duo = [];
        $duo = DB::table('visite_duo')->where('visite_id', $visite)->select('responsable_id')->get();
        $responsable = [];
        $responsable = DB::table('users')
            ->join('user_responsables', 'user_responsables.responsable_id', 'users.id')
            ->select('users.id', 'users.firstname', 'users.lastname')
            ->where('user_responsables.user_id', Auth::id())
            ->get();
        return view('visites.pharmacy._form_duo', ['responsable' => $responsable, 'duo' => $duo]);
    }

    public function visiteduo(Request $request)
    {
        $visite = Visite::find($request->visiteId);
        $visite->step = 5;
        $visite->save();
        if ($request->visiteId != 0) {

            $visite = Visite::find($request->visiteId);
            $user_id = Auth::id();
            for ($i = 0; $i < count($request->responsable); $i++) {
                $visite->duos()->attach($user_id, [
                    'responsable_id' =>  $request->responsable[$i],
                    'note' => null
                ]);
            }
        }

        $plvIDs = [];
        $client_plvs_id = DB::table('client_plv')->join('plvs', 'plvs.id', 'client_plv.plv_id')
            ->select('plvs.id')
            ->where('client_id', $request->client_id)
            ->whereNull('finished_at')->get();
        for ($i = 0; $i < count($client_plvs_id); $i++) {
            array_push($plvIDs, $client_plvs_id[$i]->id);
        }
        $plvs = Plv::whereNotIn('id', $plvIDs)->get();
        $client = Client::find($request->client_id);
        return view('visites.pharmacy._form_plv', ['plvs' => $plvs, 'client' => $client]);
    }

    public function plv($visite, $client)
    {

        $visites = Visite::find($visite);
        if ($visites->step == 4) {
            $visites->step = 5;
            $visites->save();
        }

        $plvIDs = [];
        $client_plvs_id = DB::table('client_plv')->join('plvs', 'plvs.id', 'client_plv.plv_id')
            ->select('plvs.id')
            ->where('client_id', $client)
            ->whereNull('finished_at')->get();

        for ($i = 0; $i < count($client_plvs_id); $i++) {
            array_push($plvIDs, $client_plvs_id[$i]->id);
        }
       // $plvs = Plv::whereNotIn('id', $plvIDs)->get();
       $users=[];
       array_push($users,Auth::id());
       $networks = $this->networkRepository->getNetworksIdsByUser($users);

       $plvs = Plv::join('plv_network','plv_network.plv_id','plvs.id')
       ->select('plvs.id', 'plvs.designation')
       ->whereIn('plv_network.network_id',$networks)->whereNotIn('plvs.id', $plvIDs)->get();

       
        $client_plvs = DB::table('client_plv')->join('plvs', 'plvs.id', 'client_plv.plv_id')
            ->select('client_plv.id', 'plvs.designation', 'plvs.id as plv_id')
            ->where('client_id', $client)
            ->whereNull('finished_at')->get();
           
        return view('visites.pharmacy._form_plv', ['client_plvs' => $client_plvs, 'plvs' => $plvs]);
    }

    public function visiteplv(Request $request)
    {

        DB::table('client_plv')->insert(['client_id' => $request->client_id, 'plv_id' => $request->plv_id, 'created_at' => carbon::now(),'created_by'=>Auth::id()]);

        $client_plvs = DB::table('client_plv')->join('plvs', 'plvs.id', 'client_plv.plv_id')
            ->select('client_plv.id', 'plvs.designation', 'plvs.id as plv_id', 'client_plv.created_at')
            ->where('client_id', $request->client_id)
            ->whereNull('finished_at')->get();

        return view('visites.pharmacy.table_visite_plv', ['client_plvs' => $client_plvs]);
    }

    public function deleteplv($id)
    {
        $client_id = DB::table('client_plv')->where('id', $id)->value('client_id');
        DB::table('client_plv')->where('id', $id)->update(['finished_at' => Carbon::now(),'deleted_by'=>Auth::id()]);

        $client_plvs = DB::table('client_plv')->join('plvs', 'plvs.id', 'client_plv.plv_id')
            ->select('client_plv.id', 'plvs.designation', 'plvs.id as plv_id', 'client_plv.created_at')
            ->where('client_id', $client_id)
            ->whereNull('finished_at')->get();

        return view('visites.pharmacy.table_visite_plv', ['client_plvs' => $client_plvs]);
      
    }

    public function getClientPlv($client_id)
    {
        $client_plvs = DB::table('client_plv')->join('plvs', 'plvs.id', 'client_plv.plv_id')
            ->select('client_plv.id', 'plvs.designation', 'plvs.id as plv_id', 'client_plv.created_at')
            ->where('client_id', $client_id)
            ->whereNull('finished_at')->get();

        return view('visites.pharmacy.table_visite_plv', ['client_plvs' => $client_plvs]);
    }



    public function emg($visite)
    {

        $visites = Visite::find($visite);
        $visites->step = 6;
        $visites->save();
        $emgIDs = $this->productRepository->productEmgIdsPharmacy($visites->id);
        $users=[];
        array_push($users,Auth::id());
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $products = $this->productRepository->productByNetwork($emgIDs,$networks);

        // $products = Product::whereNotIn('id', $emgIDs)->get();

        return view('visites.pharmacy._form_emg', ['emgs' => $products]);
    }



    public function emgStore(Request $request)
    {
        DB::table('visite_emg')->insert(['visite_id' => $request->visite_id, 'product_id' => $request->product_id, 'qte' => $request->qte]);

        return redirect()->route('visites.clientEmg.pharmacy', ['visite' => $request->visite_id]);
    }
    public function clientEmg($visite)
    {
        $visite_emgs = DB::table('visite_emg')->join('products', 'products.id', 'visite_emg.product_id')
            ->select('visite_emg.id', 'visite_emg.qte', 'products.designation', 'products.id as product_id')
            ->where('visite_id', $visite)->get();
        // dd( $visite_emgs);

        return view('visites.pharmacy.table_visite_emg', ['visite_emgs' => $visite_emgs]);
    }

    public function deleteemg($id)
    {

        $visite_id = DB::table('visite_emg')->where('id', $id)->value('visite_id');
        DB::table('visite_emg')->where('id', $id)->delete();
        return redirect()->route('visites.clientEmg.pharmacy', ['visite' => $visite_id]);
    }

    public function finVisite($id)
    {
        $visites = DB::table('ruptures')
        ->join('visites', 'visites.id', 'ruptures.visite_id')
        ->join('clients', 'clients.id', 'visites.client_id')
        ->join('users', 'users.id', 'visites.user_id')
        ->leftJoin('products', 'products.id', 'ruptures.product_id')
        ->select('clients.nom', 'users.firstname', 'users.lastname', 'ruptures.product', 'ruptures.autre','products.designation', 'visites.created_at')
        ->where('visites.id', $id)->get();

        // dd($visites);

        // if($visites->count()>0){
        //     Mail::to('sakioudio@gmail.com')
        //     ->send(new Rupture($visites));
        // }
        

        DB::table('visites')->where('id', $id)->update(['fin' => true]);
    }

    public function edit($visite)
    {
        // dd($visite);
        $client_id = DB::table('plannings')->where('visite_id', $visite)->value('client_id');
        $client = Client::select('id', 'nom', 'motif')->where('id', $client_id)->first();
        //dd($client);
        $ug_id = DB::table('clients')->where('id', $client_id)->value('ug_id');
        $medecins = Doctor::where('ug_id', $ug_id)->get();

        $doctor_id =    DB::table('visite_doctor_enquet')->where('visite_id', $visite)->value('doctor_id');
        $nbOrdonanceDoc =    DB::table('visite_doctor_enquet')->where('visite_id', $visite)->value('nb_ordonance');
        $productsIDs = [];
        $visite_products_id = DB::table('visite_product')->join('products', 'products.id', 'visite_product.product_id')
            ->select('products.id')
            ->where('visite_id', $visite)->get();

        for ($i = 0; $i < count($visite_products_id); $i++) {
            array_push($productsIDs, $visite_products_id[$i]->id);
        }

        $products = Product::whereNotIn('id', $productsIDs)->get();
        $visite = DB::table('visites')->select('id', 'type_VD', 'type_enq_ref', 'type_enq_rp', 'step', 'fin')
            ->where('id', $visite)->first();

        return view('visites.pharmacy.edit', ['visite' => $visite, 'client' => $client, 'produits' => $products, 'medecins' => $medecins, 'doctor_id' => $doctor_id,'nbOrdonanceDoc'=>$nbOrdonanceDoc]);
    }

    public function changeMultiSelect() {
        $medecins = Doctor::all();
        return view('helpers.multiSelect',['medecins' => $medecins]);
    }

    public function changeMultiSelectG() {
    
        $grossistes = Grossiste::select('id','designation')->get();
        return view('helpers.multiSelectG',['grossistes' => $grossistes]);
    }


}
