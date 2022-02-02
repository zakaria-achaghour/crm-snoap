<?php

namespace App\Http\Controllers;

use App\Http\Requests\adv\commander\StoreCommandeRequest;
use App\Http\Requests\adv\StoreAdvRequest;
use App\Models\Adv;
use App\Models\Doctor;
use App\Models\Fournisseur;
use App\Models\Month;
use App\Models\Nature;
use App\Models\Network;
use App\Models\Product;
use App\Models\Regionmc;
use App\Models\Role;
use App\Models\Ug;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdvController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin.Manager', ['only' => ['accepte']]);
        $this->middleware('can:admin.Manager+', ['only' => ['valider']]);


    }

    public function index()
    {
        $user = Auth::user();
        $advs = Adv::orderBydesc('updated_at');
        // if (in_array('Responsable-Delegue', $user->roles->pluck('name')->toArray()) ) {
        //     $advs = $advs->where('user_id',Auth::id())->where('step','=','0')->OrWhere('step','=','3')->OrWhere('step','=','5')->get();
        // }
        // if (in_array('Acheteur', $user->roles->pluck('name')->toArray()) ) {
        //     $advs = $advs->where('step','>=','')->where('step','>=','4')->get();
        // }
        if (in_array('Manager', $user->roles->pluck('name')->toArray())) {
            $advs = $advs->where('step', '>=', '1')->get();
        }
        if (in_array('Manager+', $user->roles->pluck('name')->toArray())) {
            $advs = $advs->where('step', '!=', '0')->where('step', '!=', '1')->where('step', '!=', '3')->get();
        }
        if (in_array('admin', $user->roles->pluck('name')->toArray())) {
            $advs = $advs->get();
        }

        return view('adv.adv.index', ['advs' => $advs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $networks = Network::select('id', 'designation')->get();
        $regionmcs = Regionmc::select('id', 'designation')->get();
        $natures = Nature::select('id', 'designation')->get();
        $months = Month::select('id', 'Mois')->get();
        $demandeurs =  Role::where('name', 'Responsable-Delegue')->first()->users;
        //    $demandeurs = DB::table('users')->join('role_user','role_user.user_id','users.id')
        //                                   ->join('roles','roles.id','role_user.role_id')
        //                                   ->select('users.id','firstname','lastname')
        //                                   ->whereIn('name',['delegue','Responsable-Delegue'])
        //                                   ->get();
        //   dd($demandeurs);
        return view('adv.adv.create', ['demandeurs' => $demandeurs, 'networks' => $networks, 'regionmcs' => $regionmcs, 'ugs' => [], 'doctors' => [], 'doctor' => [], 'natures' => $natures, 'months' => $months]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvRequest $request)
    {
        //dd($request->all());
        $adv = new Adv();
        $adv->user_id = $request->demandeur;
        $adv->network_id = $request->network;
        $adv->rubrique = $request->rubrique;

        $adv->doctor_id = $request->doctor;
        $adv->nature_id = $request->nature;
        $adv->nature_detail = $request->dNature;
        $adv->budget_prev = $request->budgetPrev;
        $adv->step = 0;

        $adv->month_id = $request->month;
        $adv->date_debut = $request->debut;
        $adv->date_fin = $request->fin;

        $adv->save();

        return redirect()->route('advs.edit', ['adv' => $adv->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adv  $adv
     * @return \Illuminate\Http\Response
     */
    public function show(Adv $adv)
    {
        $products = DB::table('adv_product')
            ->join('products', 'products.id', 'adv_product.product_id')

            ->select('products.designation', 'products.id as product_id', 'adv_product.qte', 'adv_product.id')

            ->where('adv_product.adv_id', $adv->id)
            ->get();
        return view('adv.adv.show', ['adv' => $adv, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adv  $adv
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adv = Adv::where('id', $id)->with(['month', 'doctor', 'doctor.ug', 'doctor.ug.region'])->first();

        return view('adv.adv.edit', ['adv' => $adv]);
    }

    public function productForm($id)
    {
        // $adv = Adv::where('id',$id)->with(['doctor','doctor.ug','doctor.ug.region'])->first();

        $productsIDs = [];
        $adv_products_id = DB::table('adv_product')->join('products', 'products.id', 'adv_product.product_id')
            ->select('products.id')
            ->where('adv_id', $id)->get();

        for ($i = 0; $i < count($adv_products_id); $i++) {
            array_push($productsIDs, $adv_products_id[$i]->id);
        }

        $products = Product::whereNotIn('id', $productsIDs)->get();

        return view('adv.adv._form_product', ['products' => $products]);
    }

    public function affecterProductsAdv(Request $request)
    {
        //dd('ok');
        //  dd($request->all());
        DB::table('adv_product')->insert(['adv_id' => $request->adv, 'product_id' => $request->productID, 'qte' => $request->qteProduct, 'created_at' => Carbon::now()]);
        return redirect()->route('advs.ProductTable', ['id' => $request->adv]);
    }

    public function productTable($id)
    {
        $products = DB::table('adv_product')
            ->join('products', 'products.id', 'adv_product.product_id')
            ->select('products.designation', 'products.id as product_id', 'adv_product.qte', 'adv_product.id')
            ->where('adv_product.adv_id', $id)
            ->get();

        return view('adv.adv.table_product', ['products' => $products]);
    }


    public function deleteProduct($id)
    {
        $adv_id = DB::table('adv_product')->where('id', $id)->value('adv_id');
        DB::table('adv_product')->where('id', $id)->delete();
        return redirect()->route('advs.ProductTable', ['id' => $adv_id]);
    }

    public function fin($id)
    {

        DB::table('advs')->where('id', $id)->update(['step' => 1, 'updated_at' => Carbon::now()]);

        // return view('adv.creer.index');
    }
    public function changeStatus($step, $adv)
    {

        DB::table('advs')->where('id', $adv)->update(['step' => $step, 'updated_at' => Carbon::now()]);
    }

    public function getDoctorByUg($ug_id)
    {
        // $doctors = Doctor::join('specialties', 'specialties.id', 'doctors.specialty_id')->select('doctors.id','name', 'adresse', 'specialties.designation')->where('ug_id',$ug_id)->get();
        $doctors = Doctor::select('id', 'name', 'adresse', 'specialty_id')->with('specialty')->get();

        return view('adv.adv.doctors', ['doctors' => $doctors]);
    }
    public function getUgByRegionmc($regionmc_id)
    {
        $ugs = Ug::select('id', 'designation')->where('regionmc_id', $regionmc_id)->get();

        return view('adv.adv.ug', ['ugs' => $ugs]);
    }

    public function getDoctorInfo($doctor_id)
    {

        $doctor = Doctor::find($doctor_id);
        return view('adv.adv.doctorInfo', ['doctor' => $doctor]);
    }

    // public function encours(){

    //     $advs = Adv::orderBydesc('updated_at')->where('step',0)->get();
    //     return view('adv.encours.index',['advs'=>$advs]);
    // }

    public function cree()
    {

        $advs = Adv::orderBydesc('updated_at')->where('step', '<=', '1')->get();
        return view('adv.creer.index', ['advs' => $advs]);
    }

    public function accepte()
    {

        $advs = Adv::orderBydesc('updated_at')->where('step', 1)->get();
        return view('adv.accepter.index', ['advs' => $advs]);
    }

    public function valider()
    {
        $advs = Adv::orderBydesc('updated_at')->where('step', '2')->get();
        return view('adv.valider.index', ['advs' => $advs]);
    }

    public function commande(Adv $adv)
    {
        $fournisseur = Fournisseur::all();
        return view('adv.commander.create', ['fournisseurs' => $fournisseur, 'adv' => $adv]);
    }

    public function commandeStore(StoreCommandeRequest $request)
    {

        $adv = DB::table('advs')->where('id', $request->id)->update(['step' => 6, 'tva' => $request->tva, 'budget_reel' => $request->budgetReel, 'fournisseur_id' => $request->fournisseur, 'updated_at' => Carbon::now()]);

        // $advs = Adv::all();
        // return view('adv.adv.index',['advs'=>$advs]);
    }

    public function pourCommande()
    {
        $advs = Adv::orderBydesc('updated_at')->where('step', '=', '4')->get();


        return view('adv.index', ['advs' => $advs]);
    }

    public function pourLivrer()
    {
        $advs = Adv::orderBydesc('updated_at')->where('step', '=', '6')->get();


        return view('adv.index', ['advs' => $advs]);
    }

    public function livrer($id)
    {
        //$adv = Adv::where('id',$id)->with(['month','doctor','doctor.ug','doctor.ug.region','ug.region'])->first();
        $adv = Adv::join('doctors', 'doctors.id', 'advs.doctor_id')
            ->join('ugs', 'ugs.id', 'doctors.ug_id')->join('regionmcs', 'regionmcs.id', 'ugs.regionmc_id')
            ->select('advs.id', 'advs.user_id', 'advs.network_id', 'regionmcs.id as regionmc', 'ugs.id as ug', 'advs.doctor_id')
            ->where('advs.id', $id)
            ->first();
        //dd($adv);
        // $doctors = Doctor::all();
        $demandeurs =  Role::where('name', 'Responsable-Delegue')->first()->users;
        $networks = Network::select('id', 'designation')->get();
        $regionmcs = Regionmc::select('id', 'designation')->get();
        $ugs = Ug::select('id', 'designation')->where('regionmc_id', $adv->regionmc)->get();
        $doctors = Doctor::select('id', 'name', 'adresse', 'specialty_id')->with('specialty')->where('ug_id', $adv->ug)->get();


        return view('adv.livrer.edit', [
            'adv' => $adv, 'demandeurs' => $demandeurs,
            'networks' => $networks, 'regionmcs' => $regionmcs,
            'ugs' => $ugs, 'doctors' => $doctors
        ]);
    }

    public function livrerStore(Request $request)
    {

        $adv = Adv::find($request->adv);
        if ($adv->user_id != $request->demandeur) {
            $adv->autre_user_id = $request->demandeur;
        }
        if ($adv->doctor_id != $request->doctor) {
            $adv->autre_doctor_id = $request->doctor;
        }

        $adv->step = 7;
        $adv->save();
        return redirect()->route('advs.historique');
    }

    public function historique()
    {
        // dd('qsd');
        //$advs= Adv::where('step',7)->orderByDesc('id')->get();

        $advs = Adv::select(
            'id',
            'doctor_id',
            'user_id',
            'nature_id',
            'step',
            DB::raw("(select name from doctors where doctors.id = autre_doctor_id) as autre_doctor"),
            DB::raw("(select specialties.designation as autre_specialty from doctors , specialties  where doctors.id = autre_doctor_id and doctors.specialty_id = specialties.id) as autre_specialty"),
            DB::raw("(select concat(firstname ,' ', lastname) as name from users where users.id = autre_user_id) as autre_user"),
        )
            ->where('step', 7)
            ->orderByDesc('id')->get();
        //dd($advs);
        return view('adv.historique.index', ['advs' => $advs]);
    }

    public function print($id)
    {

        $adv = Adv::select(
            'id',
            'doctor_id',
            'user_id',
            'nature_id',
            'budget_reel',
            'nature_detail',
            'month_id',
            'tva',
            'updated_at',
            DB::raw("(select name from doctors where doctors.id = autre_doctor_id) as autre_doctor"),
            DB::raw("(select specialties.designation as autre_specialty from doctors , specialties  where doctors.id = autre_doctor_id and doctors.specialty_id = specialties.id) as autre_specialty"),
            DB::raw("(select concat(firstname ,' ', lastname) as name from users where users.id = autre_user_id) as autre_user"),
        )
            ->where('id', $id)
            ->orderByDesc('id')->first();
        return view('adv.livrer.print', ['adv' => $adv]);
    }
}
