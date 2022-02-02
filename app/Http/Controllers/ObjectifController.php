<?php

namespace App\Http\Controllers;

use App\Models\Objectif;
use App\Models\Ug;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObjectifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objectifs = DB::table('objectifs')->join('users','users.id','objectifs.user_id')->join('ugs', 'ugs.id', 'objectifs.ug_id')
                            ->select('objectifs.id','objectifs.de','objectifs.a','montant','nombre_medecine','ugs.designation as ug','users.firstname','users.lastname')
                            ->get();
                            
        return View('objectif.index',['objectifs'=>  $objectifs]);
    }


    public function product($objectif_id){
        $productsIDs = [];
        $objectif_products_id = DB::table('objectif_product')->select('product_id')->where('objectif_id', $objectif_id)->get();

        for ($i = 0; $i < count($objectif_products_id); $i++) {
            array_push($productsIDs, $objectif_products_id[$i]->product_id);
        }
        
        $products = DB::table('products')->select('id', 'designation')->whereNotIn('id', $productsIDs)->get();
        
        return view('objectif._form_product',['products'=>$products,'objectif_id'=>$objectif_id]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $responsables = DB::table('users')->join('role_user','role_user.user_id','users.id')->join('roles','roles.id','role_user.role_id')
                        ->select('users.id','users.firstname','users.lastname')
                        ->where('roles.name','Responsable-Delegue')
                        ->whereNull('users.deleted_at')
                        ->get();
                       
        return view('objectif.create',['responsables'=>$responsables]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $objectif = new Objectif();
        $objectif->user_id = $request->responsable;
        $objectif->montant = $request->montant;
        $objectif->ug_id = $request->ugs;
        $objectif->de = $request->de;
        $objectif->a = $request->a;
        $objectif->nombre_medecine= $request->medecine;
        $objectif->save();

        return redirect()->route('objectifs.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function edit(Objectif $objectif)
    {
        $responsables = DB::table('users')->join('role_user','role_user.user_id','users.id')->join('roles','roles.id','role_user.role_id')
        ->select('users.id','users.firstname','users.lastname')
        ->where('roles.name','Responsable-Delegue')
        ->whereNull('users.deleted_at')
        ->get();
            return view('objectif.edit',['responsables'=>$responsables,'objectif'=>$objectif]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Objectif  $objectif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objectif $objectif)
    {
        $objectif->user_id = $request->responsable;
        $objectif->montant = $request->montant;
        $objectif->nombre_boite = $request->boite;
        $objectif->nombre_medecine= $request->medecine;
        $objectif->save();

        return redirect()->route('objectifs.index');
    }

    public function affecterNombreBoite(Request $request)
   {
       // dd($request->all());
        DB::table('objectif_product')->insert(['objectif_id'=>$request->objectif_id , 'product_id'=>$request->product_id,'nombre_boite'=>$request->qte,'created_at'=>Carbon::now()]);

        return redirect()->route('objectifs.product.table',['id'=>$request->objectif_id]);
    }

    public function productObjectifTab($id){

        $products = DB::table('objectif_product')->join('products','products.id','objectif_product.product_id')
                                    ->select('products.designation','objectif_product.nombre_boite','objectif_product.id','objectif_product.product_id')
                                    ->where('objectif_product.objectif_id',$id)->get();


        return view('objectif.productObjectifTab',['products'=>$products]);
    }

    public function productObjectifDestroy($id,$objectif_id){


        DB::table('objectif_product')->where('id',$id)->delete();
        return redirect()->route('objectifs.product.table',['id'=>$objectif_id]);

    }

    
    public function getUg($user_id){
        $ugs = DB::table('ugs')
             ->join('regionmcs', 'regionmcs.id',  'ugs.regionmc_id')
            ->join('regionmc_networks', 'regionmc_networks.regionmc_id',  'regionmcs.id')
            ->join('user_regionmc_network', 'user_regionmc_network.regionmc_network_id','regionmc_networks.id')
            ->select('ugs.designation', 'ugs.id')->distinct()
            ->where('user_regionmc_network.user_id', $user_id)
            ->get();
        
        return view('objectif.ugs',['ugs'=>$ugs]);

    }
    
  
}
