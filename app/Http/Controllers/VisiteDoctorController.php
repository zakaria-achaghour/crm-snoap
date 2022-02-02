<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Plv;
use App\Models\Product;
use App\Models\VisiteDoctor;
use App\Repositories\NetworkRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RegionRepository;
use App\Repositories\UgRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisiteDoctorController extends Controller
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
            return view('visites.doctors.index', ['delegues' => $delegues]);



        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
            return view('visites.doctors.index', ['delegues' => $delegues]);



        }
        else{
            return view('visites.doctors.index_delegue');

        }
    }

    public function visiteUser($id)
    {
        $visites = DB::table('visite_doctors')
            ->join('doctors', 'doctors.id', 'visite_doctors.doctor_id')
            ->select('doctors.name', 'doctors.adresse', 'visite_doctors.id', 'visite_doctors.user_id', 'visite_doctors.created_at', 'visite_doctors.fin')
            ->where('visite_doctors.user_id', $id)
            ->orderBy('id', 'DESC')
            ->limit('100')
            ->get();
        //  dd($visites);
        return view('visites.doctors.visite', ['visites' => $visites]);
    }

    public function recherche($de, $a, $user)
    {

        $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $visites = DB::Table('visite_doctors')
                        ->join('doctors', 'doctors.id', 'visite_doctors.doctor_id')
                        ->select('doctors.name', 'doctors.adresse', 'visite_doctors.*')
                        ->where('visite_doctors.user_id', $user)
                        ->whereBetween('visite_doctors.created_at', [$de, $a])
                        ->orderBy('visite_doctors.id', 'DESC')
                        ->get();

        return view('visites.doctors.visite', ['visites' => $visites]);
    }

    public function create($doctor, $planning)
    {
        $visite_id = DB::table('planning_doctors')->where('id', $planning)->value('visite_doctor_id');
     
        if ($visite_id == NULL) {
            $doctor = Doctor::join('specialties','specialties.id','doctors.specialty_id')->select('doctors.id', 'name', 'motif','specialties.designation as specialite')->where('doctors.id', $doctor)->first();

            $h_produits = DB::table('visite_doctor_product')
            ->join('products', 'products.id', 'visite_doctor_product.product_id')
            ->join('visite_doctors', 'visite_doctors.id', 'visite_doctor_product.visite_doctor_id')
            ->select('visite_doctors.created_at','products.designation', 'visite_doctor_product.qte')
            ->where('visite_doctors.doctor_id', $doctor->id )
            ->orderBy('visite_doctors.created_at')->get();

            $demandes = DB::table('visite_doctors')
            ->join('users', 'users.id', 'visite_doctors.user_id')
            ->select('demande_special', 'visite_doctors.created_at', 'firstname', 'lastname')
            ->where('doctor_id',$doctor->id)->whereNotNull('demande_special')->orderByDesc('visite_doctors.id')->get();
    
           // $medecins = Doctor::where('ug_id',$ug_id)->get();

            return view('visites.doctors.create', ['doctor' => $doctor, 'h_produits' => $h_produits, 'planning' => $planning,'demandes'=>$demandes]);
        } else {

            return redirect()->route('visites.edit.doctor', ['visite_id' => $visite_id]);
        }
    }

    public function store(Request $request)
    {
       // dd($request->all());

         $visite_id = DB::table('planning_doctors')->where('id', $request->planning_id)->value('visite_doctor_id');
        if ($visite_id != NULL) {
            return redirect()->route('visitesEdit', ['visite_id' => $visite_id]);
        } else {
           
        //     //  save viste remmeber
            $visite = new VisiteDoctor();
            $visite->doctor_id = $request->doctorId;
            $visite->nombre_patient = $request->patient;

            $visite->user_id = Auth::id();
            $visite->step = 1;
            $visite->save();

              DB::table('planning_doctors')->where('id', $request->planning_id)->update(['done' => 1, 'visite_doctor_id' => $visite->id]);
              DB::table('doctors')->where('id', $request->doctorId)->update(['reserved' => 0]);

             return redirect()->route('visites.edit.doctor', ['visite_id' => $visite->id]);
         }
    }


    public function edit($visite)
    {
        $doctor_id = DB::table('planning_doctors')->where('visite_doctor_id',$visite)->value('doctor_id');
        $demandes = DB::table('visite_doctors')
        ->join('users', 'users.id', 'visite_doctors.user_id')
        ->select('demande_special', 'visite_doctors.created_at', 'firstname', 'lastname')->where('doctor_id',$doctor_id)->whereNotNull('demande_special')->orderByDesc('visite_doctors.id')->get();

        $doctor = Doctor::join('specialties','specialties.id','doctors.specialty_id')->select('doctors.id', 'name', 'motif','specialties.designation as specialite')->where('doctors.id', $doctor_id)->first();
       

        // chercher for last visite id 
        $last_visite = DB::table('visite_doctors')->select(DB::raw("(select top(1) id from visite_doctors where visite_doctors.doctor_id=".$doctor_id." and visite_doctors.fin=1 order by created_at desc) as id " ))->first();
   
       //dd($products);
        $h_produits = DB::table('visite_doctor_product')
            ->join('products', 'products.id', 'visite_doctor_product.product_id')
            ->join('visite_doctors', 'visite_doctors.id', 'visite_doctor_product.visite_doctor_id')
            ->select('visite_doctors.created_at','products.designation', 'visite_doctor_product.qte')
            ->where('visite_doctors.doctor_id', $doctor->id )
            ->where('visite_doctors.fin',1)

            ->orderBy('visite_doctors.created_at')->get();
        
        $visite = DB::table('visite_doctors')->select('id','nombre_patient','demande_special', 'step', 'fin')
            ->where('id', $visite)->first();

        return view('visites.doctors.edit', ['visite' => $visite, 'doctor' => $doctor, 'h_produits' => $h_produits, 'demandes' => $demandes]);
    }

    public function DisplayProduct($visite_id)
    {

        

         $doctor_id = DB::table('visite_doctors')->where('id',$visite_id)->value('doctor_id');
         $users=[];
         array_push($users,Auth::id());
         $networks = $this->networkRepository->getNetworksIdsByUser($users);
         $productIds = $this->productRepository->productIdsByVisiteDoctor($visite_id);

         //chercher last visite
        $last_visite = DB::table('visite_doctors')->select(DB::raw("(select top(1) id from visite_doctors where visite_doctors.doctor_id=".$doctor_id." and visite_doctors.fin=1 order by created_at desc) as id " ))->first();

        if ($last_visite->id==NULL){
            $products =  $this->productRepository->productVisiteDoctorWhenLastIdNull($productIds,$networks);
        }else{
            $products =  $this->productRepository->productVisiteDoctorWhenLastExist($productIds,$networks,$last_visite->id,$doctor_id);

        }   
       

        return view('visites.doctors._form_products', ['produits' => $products]);
    }

    public function product(Request $request)
    {
      
        $visite = VisiteDoctor::find($request->visiteId);
        $product = Product::find($request->productID);
        $visite->products()->attach($product, [
            'qte' => (int) $request->qteProduct,
            'miseEnPlace' => (int)$request->misenplace
        ]);

        return redirect()->route('visites.productTable.doctor', ['id' =>$request->visiteId]);
    }

    public function productTable($id)
    {
        $products = DB::table('visite_doctor_product')
            ->join('products', 'products.id', 'visite_doctor_product.product_id')
            ->select('products.designation', 'products.id as product_id', 'visite_doctor_product.miseEnPlace', 'visite_doctor_product.qte', 'visite_doctor_product.id')
            ->where('visite_doctor_product.visite_doctor_id', $id)
            ->get();
        return view('visites.doctors.table_visite_product', ['products' => $products]);
    }

    public function productDestroy($id)
    {

        $visite_id = DB::table('visite_doctor_product')->where('id', $id)->value('visite_doctor_id');
        DB::table('visite_doctor_product')->where('id', $id)->delete();
        return redirect()->route('visites.productTable.doctor', ['id' => $visite_id]);
    }


    public function duo($visite)
    {

       // dd('good');

        //dd($from);
        $visites = VisiteDoctor::find($visite);
      
            if ($visites->step == 1) {
                $visites->step = 2;
                $visites->save();
            }
       

        $duo = [];
        $duo = DB::table('visite_doctor_duo')->where('visite_doctor_id', $visite)->select('responsable_id')->get();

        $responsable = [];

        $responsable = DB::table('users')
            ->join('user_responsables', 'user_responsables.responsable_id', 'users.id')
            ->select('users.id', 'users.firstname', 'users.lastname')
            ->where('user_responsables.user_id', Auth::id())
            ->get();
        return view('visites.doctors._form_duo', ['responsable' => $responsable, 'duo' => $duo]);
    }

    public function visiteduo(Request $request)
    {
        $visite = VisiteDoctor::find($request->visiteId);
        $visite->step = 3;
        $visite->save();
        if ($request->visiteId != 0) {

            $visite = VisiteDoctor::find($request->visiteId);
            $user_id = Auth::id();
            for ($i = 0; $i < count($request->responsable); $i++) {
                $visite->duos()->attach($user_id, [
                    'responsable_id' =>  $request->responsable[$i],
                    'note' => null
                ]);
            }
        }

        $plvIDs = [];
        $client_plvs_id = DB::table('doctor_plv')->join('plvs', 'plvs.id', 'doctor_plv.plv_id')
            ->select('plvs.id')
            ->where('doctor_id', $request->client_id)
            ->whereNull('finished_at')->get();
        for ($i = 0; $i < count($client_plvs_id); $i++) {
            array_push($plvIDs, $client_plvs_id[$i]->id);
        }
        $plvs = Plv::whereNotIn('id', $plvIDs)->get();
        $client = Doctor::find($request->client_id);
        return view('visites.doctors._form_plv', ['plvs' => $plvs, 'client' => $client]);
    }


    public function plv($visite, $client)
    {

        $visites = VisiteDoctor::find($visite);
        if ($visites->step == 2) {
            $visites->step = 3;
            $visites->save();
        }

        $plvIDs = [];
       
              
        $client_plvs_id = DB::table('doctor_plv')->join('plvs', 'plvs.id', 'doctor_plv.plv_id')
                            ->select('plvs.id')
                            ->where('doctor_id', $client)
                            ->whereNull('finished_at')->get();
            

        for ($i = 0; $i < count($client_plvs_id); $i++) {
            array_push($plvIDs, $client_plvs_id[$i]->id);
        }

        $users=[];
        array_push($users,Auth::id());
        $networks = $this->networkRepository->getNetworksIdsByUser($users);

        $plvs = Plv::join('plv_network','plv_network.plv_id','plvs.id')
        ->select('plvs.id', 'plvs.designation')
        ->whereIn('plv_network.network_id',$networks)->whereNotIn('plvs.id', $plvIDs)->get();

            
        $client_plvs = DB::table('doctor_plv')->join('plvs', 'plvs.id', 'doctor_plv.plv_id')
        ->select('doctor_plv.id', 'plvs.designation', 'plvs.id as plv_id', 'doctor_plv.created_at')
        ->where('doctor_id', $client)
        ->whereNull('finished_at')->get();
       
      
        return view('visites.doctors._form_plv', ['client_plvs' => $client_plvs, 'plvs' => $plvs]);
    }


    public function visiteplv(Request $request)
    {

        DB::table('doctor_plv')->insert(['doctor_id' => $request->client_id, 'plv_id' => $request->plv_id, 'created_at' => carbon::now(),'created_by'=>Auth::id()]);

       return redirect()->route('visites.getClientPlv.doctor', ['client_id' => $request->client_id]);

    }

    public function deleteplv($id)
    {
        $client_id = DB::table('doctor_plv')->where('id', $id)->value('doctor_id');
        DB::table('doctor_plv')->where('id', $id)->update(['finished_at' => Carbon::now(),'deleted_by'=>Auth::id()]);

        return redirect()->route('visites.getClientPlv.doctor', ['client_id' => $client_id]);


    }

    public function getClientPlv($client_id)
    {

        $client_plvs = DB::table('doctor_plv')->join('plvs', 'plvs.id', 'doctor_plv.plv_id')
            ->select('doctor_plv.id', 'plvs.designation', 'plvs.id as plv_id', 'doctor_plv.created_at')
            ->where('doctor_id', $client_id)
            ->whereNull('finished_at')->get();

        return view('visites.doctors.table_visite_plv', ['client_plvs' => $client_plvs]);
    }

    
    public function emg($visite)
    {

        $visites = VisiteDoctor::find($visite);
        $visites->step = 4;
        $visites->save();
        $users=[];
        array_push($users,Auth::id());
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $productIds = $this->productRepository->productEmgIdsDoctor($visites->id);
        $products =  $this->productRepository->productEmgvisiteDoctor($productIds,$networks,$visites->id,$visites->doctor_id);
        return view('visites.doctors._form_emg', ['emgs' => $products]);
    }



    public function emgStore(Request $request)
    {
        DB::table('visite_doctor_emg')->insert(['visite_doctor_id' => $request->visite_id, 'product_id' => $request->product_id, 'qte' => $request->qte]);
        return redirect()->route('visites.clientEmg.doctor', ['visite' => $request->visite_id ]);
    }
    public function clientEmg($visite)
    {
        $visite_emgs = DB::table('visite_doctor_emg')->join('products', 'products.id', 'visite_doctor_emg.product_id')
            ->select('visite_doctor_emg.id', 'visite_doctor_emg.qte', 'products.designation', 'products.id as product_id')
            ->where('visite_doctor_id', $visite)->get();
        return view('visites.doctors.table_visite_emg', ['visite_emgs' => $visite_emgs]);
    }

    public function deleteemg($id)
    {
        $visite_id = DB::table('visite_doctor_emg')->where('id', $id)->value('visite_doctor_id');
        DB::table('visite_doctor_emg')->where('id', $id)->delete();
       return redirect()->route('visites.clientEmg.doctor', ['visite' => $visite_id ]);

    }

    public function demandeDoctor($visite_id){
        $visites = VisiteDoctor::find($visite_id);
        $visites->step = 5;
        $visites->save();
        return view('visites.doctors._form_demande_special');
    }
    public function demandeDoctorStore(Request $request){
        $visite = VisiteDoctor::find($request->visiteId);
        $visite->demande_special = $request->demande;
        $visite->save();
        $this->finVisite($request->visiteId);
    }

    public function finVisite($id)
    {
        DB::table('visite_doctors')->where('id', $id)->update(['fin' => true]);
    }


  
}
