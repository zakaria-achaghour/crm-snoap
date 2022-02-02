<?php

namespace App\Http\Controllers;

use App\Exports\EmgExportView;
use App\Exports\FicheExportView;
use App\Exports\NombresExportView;
use App\Exports\NombresRegionsExportView;
use App\Exports\PlvExportView;
use App\Exports\RapportExportView;
use App\Exports\VisiteRuptureExportView;
use App\Exports\VisitesClientExportView;
use App\Models\Product;
use App\Models\Region;
use App\Models\Regionmc;
use App\Models\Ug;
use App\Repositories\NetworkRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RegionRepository;
use App\Repositories\UgRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RapportController extends Controller
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

    public function index() {

        $de =  Carbon::now()->startOfMonth()->format('Y-m-d'); 

        $a =  Carbon::now()->addDays(1)->format('Y-m-d');

        // $this->changeChartByDate($de,$a);
        $labels = [];
        $dataset = [];
        $dataset2 = [];
        $dataset3 = [];
       
        $regions = DB::table('regionmcs')->select('designation','id',
        DB::raw("(select count(distinct(visites.id)) from visites, clients, ug_numug, ugs where  visites.client_id=clients.id 
        and clients.ugmc=ug_numug.num_ug and ug_numug.ug_id=ugs.id 
        and ugs.regionmc_id=regionmcs.id 
        and visites.fin=1 
        and visites.created_at between '$de' and '$a'  ) as visitePharma"),
        DB::raw("(select count(distinct(commandes.id)) from commandes, visites, clients, ug_numug, ugs
        where  visites.id=commandes.visite_id 
        and visites.client_id=clients.id 
        and clients.ugmc=ug_numug.num_ug 
        and ug_numug.ug_id=ugs.id 
        and ugs.regionmc_id=regionmcs.id 
        and visites.fin=1 
        and visites.created_at between '$de' and '$a'  ) as commande"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and visite_doctors.created_at between '$de' and '$a' ) as visiteMed"
        ))->get();

       // dd($regions);
        // dd($regions);
        foreach($regions as $region){
            array_push($labels, $region->designation);
            array_push($dataset, $region->visitePharma);
            array_push($dataset2, $region->visiteMed);
            array_push($dataset3, $region->commande);
        }

        $labelsNb = [];
        $datasetNb = [];
        $dataset2Nb = [];
        $dataset3Nb = [];
        $year = Carbon::now()->format('Y');
        $mois = Carbon::now()->format('m');

        $visites = DB::table('months')->select('Mois','id',
        DB::raw('(select count(*) from visites where visites.fin=1 and datepart(m,created_at)=months.id and datepart(yyyy,created_at)='.$year.' ) as visitePharma'),
        DB::raw('(select count(*) from commandes, visites where commandes.visite_id=visites.id and visites.fin=1 and datepart(m,visites.created_at)=months.id and datepart(yyyy,visites.created_at)='.$year.' ) as commande'),
        DB::raw('(select count(*) from visite_doctors where visite_doctors.fin=1 and datepart(m,created_at)=months.id and datepart(yyyy,created_at)='.$year.' ) as visiteMed'
        ))->where('id','<=',$mois)->get();
        // dd($regions);
        foreach($visites as $visite){
            array_push($labelsNb, $visite->Mois);
            array_push($datasetNb, $visite->visitePharma);
            array_push($dataset2Nb, $visite->visiteMed);
            array_push($dataset3Nb, $visite->commande);
        }

        $pharmacie = DB::table('visites')->where('fin', 1)->whereBetween('created_at', [$de, $a])->count();

        $visites = DB::table('visite_doctors')->select(
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 ) as ps"),
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1  ) as pg"),
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 ) as hs"),
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 ) as hg")
        )->limit(1)->get();
        
        $datasetPie = [];

        
        array_push($datasetPie, $visites[0]->ps);
        array_push($datasetPie, $visites[0]->pg);
        array_push($datasetPie, $visites[0]->hs);
        array_push($datasetPie, $visites[0]->hg);

        return view('rapports.index',['de'=>$de,'a'=>$a,'labels'=>$labels,'data1'=>$dataset,'data2'=>$dataset2,'data3'=>$dataset3,'labelsNb'=>$labelsNb,'data1Nb'=>$datasetNb,'data2Nb'=>$dataset2Nb,'data3Nb'=>$dataset3Nb,'visites'=>$datasetPie,'pharmacie'=>$pharmacie]);
    }

    public function changeChartByDate($de,$a){

        $labels = [];
        $dataset = [];
        $dataset2 = [];
        $dataset3 = [];

        $regions = DB::table('regionmcs')->select('designation','id',
        DB::raw("(select count(distinct(visites.id)) from visites, clients, ug_numug, ugs where  visites.client_id=clients.id 
        and clients.ugmc=ug_numug.num_ug and ug_numug.ug_id=ugs.id 
        and ugs.regionmc_id=regionmcs.id 
        and visites.fin=1 
        and visites.created_at between '$de' and '$a'  ) as visitePharma"),
        DB::raw("(select count(distinct(commandes.id)) from commandes, visites, clients, ug_numug, ugs
        where  visites.id=commandes.visite_id 
        and visites.client_id=clients.id 
        and clients.ugmc=ug_numug.num_ug 
        and ug_numug.ug_id=ugs.id 
        and ugs.regionmc_id=regionmcs.id 
        and visites.fin=1 
        and visites.created_at between '$de' and '$a'  ) as commande"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and visite_doctors.created_at between '$de' and '$a' ) as visiteMed"
        ))->get();

        // dd($regions);
        foreach($regions as $region){
            array_push($labels, $region->designation);
            array_push($dataset, $region->visitePharma);
            array_push($dataset2, $region->visiteMed);
            array_push($dataset3, $region->commande);
        }


        return view('rapports.chartBarVisitesByRegion',['labels'=>$labels,'data1'=>$dataset,'data2'=>$dataset2,'data3'=>$dataset3]);

    }

    public function changeChartByDatePie($de,$a){

        $visites = DB::table('visite_doctors')->select(
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 ) as ps"),
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1  ) as pg"),
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 ) as hs"),
            DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 ) as hg")
        )->limit(1)->get();
        
        $dataset = [];

        
        array_push($dataset, $visites[0]->ps);
        array_push($dataset, $visites[0]->pg);
        array_push($dataset, $visites[0]->hs);
        array_push($dataset, $visites[0]->hg);

        $pharmacie = DB::table('visites')->where('fin', 1)->whereBetween('created_at', [$de, $a])->count();

        return view('rapports.chartPieByDate',['visites'=>$dataset,'pharmacie'=>$pharmacie]);

    }

    public function visiteMedcine(){

        $user = Auth::user();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }

        
          $regionsmcs = $this->regionRepository->getRegionsByUser($user->id);
          $ugs =   $this->ugRepository->ugsByUser($user->id);
          $users  = [];
          array_push($users, $user->id);
          $networks = $this->networkRepository->getNetworksIdsByUser($users);
          $produits = $this->productRepository->productsByNetworks($networks);

        //$produits = Product::Select('id','designation')->get();


        return view('rapports.visiteDoctor',['regionmcs'=>$regionsmcs,'ugs'=>$ugs,'produits'=>$produits,'delegues'=>$delegues]);
    }

    public function chnageUg($regions){
        $ugs =   $this->ugRepository->ugsByUser(Auth::id());

       if($regions != 'all'){
     
        $ugs =   $this->ugRepository->ugsByUserRegion(Auth::id(),explode(',', $regions));
       }
       

        return view('rapports.ug',['ugs'=>$ugs]);
    }

    public function exporterMedecinVisite($de, $a, $region,$ug,$produit,$delegue){

        
        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');
        if($produit=='null'){
            
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegue));
           // dd($networks);
            $produits = $this->productRepository->productsByNetworks($networks);
            // $produits = DB::table('products')
            // ->select('id','products.designation')
            // ->get();
        }else{
            $produits = DB::table('products')
            ->select('id','products.designation')
            ->whereIn('products.id',explode(',', $produit))
            ->get();
        }        

        $visites= DB::Table('visite_doctors')
        ->join('doctors', 'doctors.id', 'visite_doctors.doctor_id')
        ->join('specialties', 'specialties.id', 'doctors.specialty_id')
        ->join('ugs', 'ugs.id', 'doctors.ug_id')
        ->join('regionmcs', 'regionmcs.id', 'ugs.regionmc_id')
        ->join('users', 'users.id', 'visite_doctors.user_id')
        ->select('doctors.name','doctors.adresse', 'doctors.statut_mc', 'doctors.name', 'ugs.designation as ug',
        'specialties.designation as specialite','visite_doctors.created_at as date','visite_doctors.nombre_patient as patient',
        'doctors.nombre_patients as patient_t','regionmcs.designation as region','doctors.ug_mc',
        DB::raw("CONCAT(users.firstname,' ' , users.lastname) as delegue"))
        ->where('visite_doctors.fin', 1);
        for($i=0;$i<count($produits);$i++){

            $visites->addSelect((DB::raw('(select qte from visite_doctor_product where product_id='.$produits[$i]->id.' and visite_doctor_id=visite_doctors.id    ) as ['.$produits[$i]->designation.']')));
            $visites->addSelect((DB::raw('(select qte from visite_doctor_emg where product_id='.$produits[$i]->id.' and visite_doctor_id=visite_doctors.id    ) as ['.$produits[$i]->designation.'_emg]')));
            $visites->addSelect((DB::raw('(select max(qte) from visite_product_doctor, visite_doctor_enquet 
            where visite_product_doctor.visite_id=visite_doctor_enquet.visite_id and visite_doctor_enquet.doctor_id=doctors.id and product_id='.$produits[$i]->id.' and CONVERT(DATE,visite_doctor_enquet.created_at)=CONVERT(DATE,visite_doctors.created_at)  ) as ['.$produits[$i]->designation.'_en]')));
            
        }
        if($de!=0&&$a!=0){
            $visites->whereBetween('visite_doctors.created_at',[$de,$a]);
        }
        if($region!='null'){
            $visites->whereIn('ugs.regionmc_id',explode(',', $region));
        }
        if($delegue!='null'){
            $visites->whereIn('visite_doctors.user_id',explode(',', $delegue));
        }
        if($ug!='null'){
            $visites->whereIn('ugs.id',explode(',', $ug));
        }

        $visites=$visites->get();

        return view('rapports.rapport',['visites'=>$visites,'produits'=>$produits,'produit'=>$produit,'de'=>$de, 'a'=>$a, 'region'=>$region,'ug'=>$ug,'delegues'=>$delegue]);
        
    }

    public function exporter_view($de, $a, $region,$ug,$produit,$delegue)
    {
        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegue));
            $produits = $this->productRepository->productsByNetworks($networks);
            // $produits = DB::table('products')
            // ->select('id','products.designation')
            // ->get();
        }else{
            $produits = DB::table('products')
            ->select('id','products.designation')
            ->whereIn('products.id',explode(',', $produit))
            ->get();
        }        

        $visites= DB::Table('visite_doctors')
        ->join('doctors', 'doctors.id', 'visite_doctors.doctor_id')
        ->join('specialties', 'specialties.id', 'doctors.specialty_id')
        ->join('ugs', 'ugs.id', 'doctors.ug_id')
        ->join('regionmcs', 'regionmcs.id', 'ugs.regionmc_id')
        ->join('users', 'users.id', 'visite_doctors.user_id')
        ->select('doctors.name','doctors.adresse', 'doctors.statut_mc', 'doctors.name', 'ugs.designation as ug',
        'specialties.designation as specialite','visite_doctors.created_at as date','visite_doctors.nombre_patient as patient',
        'doctors.nombre_patients as patient_t','regionmcs.designation as region','doctors.ug_mc',
        DB::raw("CONCAT(users.firstname,' ' , users.lastname) as delegue"))
        ->where('visite_doctors.fin', 1);
        if(count($produits)==0){

        }
        for($i=0;$i<count($produits);$i++){

            $visites->addSelect((DB::raw('(select qte from visite_doctor_product where product_id='.$produits[$i]->id.' and visite_doctor_id=visite_doctors.id    ) as ['.$produits[$i]->designation.']')));
            $visites->addSelect((DB::raw('(select qte from visite_doctor_emg where product_id='.$produits[$i]->id.' and visite_doctor_id=visite_doctors.id    ) as ['.$produits[$i]->designation.'_emg]')));
            $visites->addSelect((DB::raw('(select max(qte) from visite_product_doctor, visite_doctor_enquet 
            where visite_product_doctor.visite_id=visite_doctor_enquet.visite_id and visite_doctor_enquet.doctor_id=doctors.id and product_id='.$produits[$i]->id.' and CONVERT(DATE,visite_doctor_enquet.created_at)=CONVERT(DATE,visite_doctors.created_at)  ) as ['.$produits[$i]->designation.'_en]')));
        }
        if($de!=0&&$a!=0){
            $visites->whereBetween('visite_doctors.created_at',[$de,$a]);
        }
        if($region!='null'){
            $visites->whereIn('ugs.regionmc_id',explode(',', $region));
        }
        if($delegue!='null'){
            $visites->whereIn('visite_doctors.user_id',explode(',', $delegue));
        }
        if($ug!='null'){
            $visites->whereIn('ugs.id',explode(',', $ug));
        }

        $visites=$visites->get();

         return Excel::download(new RapportExportView($visites,$produits),'visite.xlsx');
    }

    public function visiteEmg() {

        $user = Auth::user();
      
        
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }

        $users=[];
        array_push($users, $user->id);
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $produits = $this->productRepository->productsByNetworks($networks);
            //dd($delegues);
        return view('rapports.emg',['delegues'=>$delegues,'produits'=>$produits]);
    }

    public function exportervisiteEmg($de, $a, $delegue,$produit){      
        
        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegue));
           // $produit = $this->productRepository->productsByNetworks($networks);
           $produit = $this->productRepository->productIdsByNetworks($networks);
           $produit = implode(',',$produit);
           
        } 
 
        $visites = DB::table('products')->select('designation');
        $visites=$visites->addSelect((DB::raw("(select sum(qte) from visite_doctor_emg, visite_doctors  where visite_doctors.id=visite_doctor_emg.visite_doctor_id and visite_doctors.user_id in ($delegue) and visite_doctors.created_at between '$de' and '$a' and product_id=products.id and visite_doctors.fin=1 group by product_id ) as qteMed")));
        $visites=$visites->addSelect((DB::raw("(select sum(qte) from visite_emg, visites where visites.id=visite_emg.visite_id and visites.user_id in ($delegue) and visites.created_at between '$de' and '$a' and product_id=products.id and visites.fin=1 group by product_id ) as qtePharma")));
        $visites = $visites->whereIn('products.id',explode(',', $produit))->get();
        $total = 0;
        foreach($visites as $visite){
            $total = $total+ $visite->qteMed + $visite->qtePharma; 
        }
        

        return view('rapports.rapportEmg',['visites'=>$visites,'produit'=>$produit,'de'=>$de, 'a'=>$a,'delegues'=>$delegue,'total'=>$total]);

        
    }

    
    public function exporter_view_emg($de, $a,$delegue,$produit){

       
        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegue));
            $produit = $this->productRepository->productIdsByNetworks($networks);
            $produit = implode(',',$produit);
            
        }

        $visites = DB::table('products')->select('designation');

        $visites=$visites->addSelect((DB::raw("(select sum(qte) from visite_doctor_emg, visite_doctors  where visite_doctors.id=visite_doctor_emg.visite_doctor_id and visite_doctors.user_id in ($delegue) and visite_doctors.created_at between '$de' and '$a' and product_id=products.id and visite_doctors.fin=1 group by product_id ) as qteMed")));
        $visites=$visites->addSelect((DB::raw("(select sum(qte) from visite_emg, visites where visites.id=visite_emg.visite_id and visites.user_id in ($delegue) and visites.created_at between '$de' and '$a' and product_id=products.id and visites.fin=1 group by product_id ) as qtePharma")));

        $visites = $visites->whereIn('products.id',explode(',', $produit))->get();
        
        $total = 0;
        foreach($visites as $visite){
            $total = $total+ $visite->qteMed + $visite->qtePharma; 
        }

        return Excel::download(new EmgExportView($visites,$total),'Emg.xlsx');

    }

    public function visiteDuo() {

        $delegues = DB::table('users')->join('role_user', 'role_user.user_id', 'users.id')
        ->join('roles', 'roles.id', 'role_user.role_id')->select('users.id', 'firstname', 'lastname')
        ->whereIn('roles.name', ['Responsable-Delegue', 'Manager', 'Manager+'])
        ->get();
        return view('rapports.duo',['delegues'=>$delegues]);
    }

    public function exportervisiteDuo($de, $a, $delegue){      
 
        $visite_doctors = DB::table('visite_doctor_duo')
                ->join('visite_doctors', 'visite_doctors.id', 'visite_doctor_duo.visite_doctor_id')
                ->join('users', 'users.id', 'visite_doctor_duo.user_id')
                ->join('doctors', 'doctors.id', 'visite_doctors.doctor_id')
                ->select(DB::raw("(select CONCAT(users.firstname,' ' , users.lastname) from users where id=visite_doctor_duo.responsable_id)  as responsable"), 'doctors.name as doctor',DB::raw("CONCAT(users.firstname,' ' , users.lastname) as delegue"), 'visite_doctor_duo.created_at')
                ->whereIn('responsable_id', explode(',', $delegue ) )
                ->whereBetween('visite_doctors.created_at',[$de,$a])
                ->get();
        $visites = DB::table('visite_duo')
             ->join('visites', 'visites.id', 'visite_duo.visite_id')
             ->join('users', 'users.id', 'visite_duo.user_id')
             ->join('clients', 'clients.id', 'visites.client_id')

             ->select(DB::raw("(select CONCAT(users.firstname,' ' , users.lastname) from users where id=visite_duo.responsable_id)  as responsable"), 'clients.nom as pharmacy',DB::raw("CONCAT(users.firstname,' ' , users.lastname) as delegue"), 'visite_duo.created_at')

            ->whereIn('responsable_id', explode(',', $delegue ) )
            ->whereBetween('visites.created_at',[$de,$a])
            ->get();
        // dd($visite_doctors);
        
        return view('rapports.rapportDuo',['visites'=>$visites,'visite_doctors'=>$visite_doctors,'de'=>$de, 'a'=>$a,'delegues'=>$delegue]);

    }

    public function exporter_view_duo($de, $a,$delegue,$produit){
       
        // if($produit=='null'){
        //     $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegue));
        //     $produit = $this->productRepository->productIdsByNetworks($networks);
        //     $produit = implode(',',$produit);
            
        // }

        // $visites = DB::table('products')->select('designation');

        // $visites=$visites->addSelect((DB::raw("(select sum(qte) from visite_doctor_emg, visite_doctors  where visite_doctors.id=visite_doctor_emg.visite_doctor_id and visite_doctors.user_id in ($delegue) and visite_doctors.created_at between '$de' and '$a' and product_id=products.id and visite_doctors.fin=1 group by product_id ) as qteMed")));
        // $visites=$visites->addSelect((DB::raw("(select sum(qte) from visite_emg, visites where visites.id=visite_emg.visite_id and visites.user_id in ($delegue) and visites.created_at between '$de' and '$a' and product_id=products.id and visites.fin=1 group by product_id ) as qtePharma")));

        // $visites = $visites->whereIn('products.id',explode(',', $produit))->get();
        
        // $total = 0;
        // foreach($visites as $visite){
        //     $total = $total+ $visite->qteMed + $visite->qtePharma; 
        // }

        // return Excel::download(new EmgExportView($visites,$total),'Emg.xlsx');

    }

    public function visitePlv() {

        $user = Auth::user();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }

        $users=[];
        array_push($users, $user->id);
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $produits = $this->productRepository->productsByNetworks($networks);
        
        return view('rapports.plv',['delegues'=>$delegues,'produits'=>$produits]);
    }
     
    public function exportervisitePlv($de, $a, $delegues,$produit){      
        
      
        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegues));
           // $produit = $this->productRepository->productsByNetworks($networks);
           $produit = $this->productRepository->productIdsByNetworks($networks);
           $produit = implode(',',$produit);
           
        } 

        $visites = DB::table('products')->select('designation');

        $visites=$visites->addSelect((DB::raw("(select count(*) from client_plv where client_plv.plv_id=products.id and client_plv.created_by in ($delegues) and client_plv.created_at between '$de' and '$a' group by plv_id ) as qte")));

        $visites = $visites->whereIn('products.id',explode(',', $produit))->get();
        
        return view('rapports.rapportPlv',['visites'=>$visites,'produit'=>$produit,'de'=>$de, 'a'=>$a,'delegues'=>$delegues]);
   
    }
    
    public function exporter_view_plv($de, $a,$delegues,$produit){

      
        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegues));
           // $produit = $this->productRepository->productsByNetworks($networks);
           $produit = $this->productRepository->productIdsByNetworks($networks);
           $produit = implode(',',$produit);
           
        } 

        $visites = DB::table('products')->select('designation');

        $visites=$visites->addSelect((DB::raw("(select count(*) from client_plv where client_plv.plv_id=products.id and client_plv.created_by in ($delegues) and client_plv.created_at between '$de' and '$a' group by plv_id ) as qte")));

        $visites = $visites->whereIn('products.id',explode(',', $produit))->get();
        
        return Excel::download(new PlvExportView($visites),'Plv.xlsx');

    }

    public function visiteFiche() {

        $user = Auth::user();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }

        $users=[];
        array_push($users, $user->id);
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $produits = $this->productRepository->productsByNetworks($networks);
        
        return view('rapports.fiche',['delegues'=>$delegues,'produits'=>$produits]);
    }
     
    public function exportervisiteFiche($de, $a, $delegues,$produit){      
        
       
        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegues));
           // $produit = $this->productRepository->productsByNetworks($networks);
           $produit = $this->productRepository->productIdsByNetworks($networks);
           $produit = implode(',',$produit);
           
        } 

        $visites = DB::table('products')->select('designation');

        $visites=$visites->addSelect((DB::raw("(select count(*) from doctor_plv where doctor_plv.plv_id=products.id and doctor_plv.created_by in ($delegues) and doctor_plv.created_at between '$de' and '$a' group by plv_id ) as qte")));

        $visites = $visites->whereIn('products.id',explode(',', $produit))->get();
        
        return view('rapports.rapportFiche',['visites'=>$visites,'produit'=>$produit,'de'=>$de, 'a'=>$a,'delegues'=>$delegues]);
   
    }
    
    public function exporter_view_Fiche($de, $a,$delegues,$produit){

       
        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegues));
           // $produit = $this->productRepository->productsByNetworks($networks);
           $produit = $this->productRepository->productIdsByNetworks($networks);
           $produit = implode(',',$produit);
           
        } 

        $visites = DB::table('products')->select('designation');

        $visites=$visites->addSelect((DB::raw("(select count(*) from doctor_plv where doctor_plv.plv_id=products.id and doctor_plv.created_by in ($delegues) and doctor_plv.created_at between '$de' and '$a' group by doctor_id ) as qte")));

        $visites = $visites->whereIn('products.id',explode(',', $produit))->get();
        
        return Excel::download(new FicheExportView($visites),'Fiche.xlsx');

    }

    public function visiteNombres() {

        $user = Auth::user();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }

      
        $regions = $this->regionRepository->getRegionsByUser($user->id);
       
        
        return view('rapports.nombres',['delegues'=>$delegues,'regions'=>$regions]);
    }
     
    public function exportervisiteNombres($de, $a, $delegues){      
        
       

        $visites = DB::table('users')->select('id','firstname', 'lastname');

        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id!=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as ps")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as pg")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id!=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as hs")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as hg")));

        $visites=$visites->addSelect((DB::raw("(select count(*) from visites where visites.user_id = users.id and visites.created_at between '$de' and '$a' and visites.fin=1 group by user_id ) as nbPharma")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from commandes, visites where commandes.visite_id=visites.id and visites.user_id = users.id and visites.created_at between '$de' and '$a' and visites.fin=1 group by user_id ) as commande")));

        $visites = $visites->whereIn('users.id',explode(',', $delegues))->get();

        $nbMed=0;
        $nbPharma=0; 
        $commande=0; 
        foreach($visites as $visite){
            $nbPharma = $nbPharma + $visite->nbPharma; 
            $nbMed = $nbMed + $visite->ps +  $visite->pg +  $visite->hs +  $visite->hg; 
            $commande = $commande + $visite->commande; 
        }
        
        return view('rapports.rapportNombres',['visites'=>$visites,'de'=>$de, 'a'=>$a,'delegues'=>$delegues,'nbPharma'=>$nbPharma,'nbMed'=>$nbMed,'commande'=>$commande]);
   
    }

    public function exportervisiteNombresRegions($de, $a, $regions) {
        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $visites = DB::table('regionmcs')->select('designation',
        DB::raw("(select count(distinct(visites.id)) from visites, clients, ugs,ug_numug where  visites.client_id=clients.id 
        and clients.ugmc=ug_numug.num_ug 
        and ug_numug.ug_id=ugs.id 
        and ugs.regionmc_id=regionmcs.id  
        and visites.fin=1 and visites.created_at between '$de' and '$a'  ) as visitePharma"),
        // DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and visite_doctors.created_at between '$de' and '$a' ) as visiteMed"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PRIVE' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' ) as ps"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PRIVE' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' ) as pg"),

        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PUBLIC' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' ) as hs"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PUBLIC' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' ) as hg"),


    );

        if($regions!= "null"){
           $visites =  $visites->whereIn('id',explode(',', $regions));
        }
        
        $visites= $visites->get();

        $visiteMed=0;
        $visitePharma=0; 
        foreach($visites as $visite){
            $visitePharma = $visitePharma + $visite->visitePharma ;  ; 
            $visiteMed = $visiteMed + $visite->pg + $visite->ps  +  $visite->hs +  $visite->hg; 
        }
    //    dd($visitePharma);
         return view('rapports.rapportNombresRegions',['visites'=>$visites,'de'=>$de, 'a'=>$a,'regions'=>$regions,'visitePharma'=>$visitePharma,'visiteMed'=>$visiteMed]);

    }
    
    public function exporter_view_Nombres($de, $a,$delegues){
        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');
        $visites = DB::table('users')->select('id','firstname', 'lastname');

        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id!=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as ps")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as pg")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id!=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as hs")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from visite_doctors ,doctors  where  visite_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id=22 and  visite_doctors.user_id= users.id and visite_doctors.created_at between '$de' and '$a' and visite_doctors.fin=1 group by user_id ) as hg")));

        $visites=$visites->addSelect((DB::raw("(select count(*) from visites where visites.user_id = users.id and visites.created_at between '$de' and '$a' and visites.fin=1 group by user_id ) as nbPharma")));
        $visites=$visites->addSelect((DB::raw("(select count(*) from commandes, visites where commandes.visite_id=visites.id and visites.user_id = users.id and visites.created_at between '$de' and '$a' and visites.fin=1 group by user_id ) as commande")));

        $visites = $visites->whereIn('users.id',explode(',', $delegues))->get();

        $nbMed=0;
        $nbPharma=0; 
        $commande=0; 
        foreach($visites as $visite){
            $nbPharma = $nbPharma + $visite->nbPharma; 
            $nbMed = $nbMed + $visite->ps +  $visite->pg +  $visite->hs +  $visite->hg; 
            $commande = $commande + $visite->commande; 
        }
        
        return Excel::download(new NombresExportView($visites,$nbMed,$nbPharma,$commande),'nombre.xlsx');

    }
    public function exporter_view_Regions($de, $a, $regions){

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $visites = DB::table('regionmcs')->select('designation',
        DB::raw("(select count(distinct(visites.id)) from visites, clients, ugs,ug_numug where  visites.client_id=clients.id 
        and clients.ugmc=ug_numug.num_ug 
        and ug_numug.ug_id=ugs.id 
        and ugs.regionmc_id=regionmcs.id  
        and visites.fin=1 and visites.created_at between '$de' and '$a'  ) as visitePharma"),
        // DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and visite_doctors.created_at between '$de' and '$a' ) as visiteMed"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PRIVE' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' ) as ps"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PRIVE' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' ) as pg"),

        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PUBLIC' and specialty_id!=22 and visite_doctors.created_at between '$de' and '$a' ) as hs"),
        DB::raw("(select count(*) from visite_doctors, doctors, ugs where  visite_doctors.doctor_id=doctors.id and doctors.ug_id=ugs.id and ugs.regionmc_id=regionmcs.id and visite_doctors.fin=1 and doctors.statut_mc='PUBLIC' and specialty_id=22 and visite_doctors.created_at between '$de' and '$a' ) as hg"),


    );

        if($regions!= "null"){
           $visites =  $visites->whereIn('id',explode(',', $regions));
        }
        
        $visites= $visites->get();

        $visiteMed=0;
        $visitePharma=0; 
        foreach($visites as $visite){
            $visitePharma = $visitePharma + $visite->visitePharma ; 
            $visiteMed = $visiteMed + $visite->ps +  $visite->pg +  $visite->hs +  $visite->hg; 
        }

        return Excel::download(new NombresRegionsExportView($visites,$visiteMed,$visitePharma),'nombreParRegions.xlsx');

    }

    public function visitePharmacies() {
        $user = Auth::user();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }

        
          $regionsmcs = $this->regionRepository->getRegionsByUser($user->id);
          $ugs =   $this->ugRepository->ugsByUser($user->id);
          $users  = [];
          array_push($users, $user->id);
          $networks = $this->networkRepository->getNetworksIdsByUser($users);
          $produits = $this->productRepository->productsByNetworks($networks);

        return view('rapports.visitePharmacy',['regionmcs'=>$regionsmcs,'ugs'=>$ugs,'produits'=>$produits,'delegues'=>$delegues]);
    }

    public function exporterPharmaciesVisite($de, $a, $region,$ug,$produit,$delegue){

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $numugs =  $this->ugRepository->numUgByUg(explode(',',$ug));
        $numugs =  implode(',',$numugs);
        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegue));
            // dd($networks);
             $produits = $this->productRepository->productsByNetworks($networks);
        }else{
            $produits = DB::table('products')
            ->select('id','products.designation')
            ->whereIn('products.id',explode(',', $produit))
            ->get();
        }        

        $visites= DB::Table('visites')
        ->join('clients', 'clients.id', 'visites.client_id')
        ->join('ug_numug', 'ug_numug.num_ug', 'clients.ugmc')
        ->join('ugs', 'ugs.id', 'ug_numug.ug_id')
        ->join('regionmcs', 'regionmcs.id', 'ugs.regionmc_id')
        ->join('users', 'users.id', 'visites.user_id')
        ->select('clients.nom','clients.pharmacien','clients.adresse', 'clients.ugmc','regionmcs.designation as region',
        'visites.created_at as date', DB::raw("CONCAT(users.firstname,' ' , users.lastname) as delegue"));
        for($i=0;$i<count($produits);$i++){
            $visites->addSelect((DB::raw('(select qte from visite_product where product_id='.$produits[$i]->id.' and visite_id=visites.id    ) as ['.$produits[$i]->designation.']')));
            $visites->addSelect((DB::raw('(select qte from visite_emg where product_id='.$produits[$i]->id.' and visite_id=visites.id    ) as ['.$produits[$i]->designation.'_emg]')));
            $visites->addSelect((DB::raw('(select miseEnPlace from visite_product where product_id='.$produits[$i]->id.' and visite_id=visites.id    ) as ['.$produits[$i]->designation.'_miseEnPlace]')));
        }
        $visites->addSelect((DB::raw('(select count(*) from commandes where visite_id=visites.id ) as commande')));
        $visites->where('visites.fin', 1);
        if($de!=0&&$a!=0){
            $visites->whereBetween('visites.created_at',[$de,$a]);
        }
        if($region!='null'){
            $visites->whereIn('ugs.regionmc_id',explode(',', $region));
        }
        if($delegue!='null'){
            $visites->whereIn('visites.user_id',explode(',', $delegue));
        }
        if($ug!='null'){
            $visites->whereIn('ugmc',explode(',', $numugs));
        }

        $visites=$visites->distinct()->get();

        // dd($visites);


        return view('rapports.rapportPharmacy',['visites'=>$visites,'produits'=>$produits,'produit'=>$produit,'de'=>$de, 'a'=>$a, 'region'=>$region,'ug'=>$ug,'delegue'=>$delegue]);
        
    }

    public function exporter_view_pharmacies($de, $a, $region,$ug,$produit,$delegue){

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $numugs =  $this->ugRepository->numUgByUg(explode(',',$ug));
        $numugs =  implode(',',$numugs);

        if($produit=='null'){
            $networks = $this->networkRepository->getNetworksIdsByUser(explode(',', $delegue));
            // dd($networks);
             $produits = $this->productRepository->productsByNetworks($networks);
        }else{
            $produits = DB::table('products')
            ->select('id','products.designation')
            ->whereIn('products.id',explode(',', $produit))
            ->get();
        }        

        $visites= DB::Table('visites')
        ->join('clients', 'clients.id', 'visites.client_id')
        ->join('ug_numug', 'ug_numug.num_ug', 'clients.ugmc')
        ->join('ugs', 'ugs.id', 'ug_numug.ug_id')
        ->join('regionmcs', 'regionmcs.id', 'ugs.regionmc_id')
        ->join('users', 'users.id', 'visites.user_id')
        ->select('clients.nom','clients.pharmacien','clients.adresse', 'clients.ugmc','regionmcs.designation as region',
        'visites.created_at as date', DB::raw("CONCAT(users.firstname,' ' , users.lastname) as delegue"));
        for($i=0;$i<count($produits);$i++){
            $visites->addSelect((DB::raw('(select qte from visite_product where product_id='.$produits[$i]->id.' and visite_id=visites.id    ) as ['.$produits[$i]->designation.']')));
            $visites->addSelect((DB::raw('(select qte from visite_emg where product_id='.$produits[$i]->id.' and visite_id=visites.id    ) as ['.$produits[$i]->designation.'_emg]')));
            $visites->addSelect((DB::raw('(select miseEnPlace from visite_product where product_id='.$produits[$i]->id.' and visite_id=visites.id    ) as ['.$produits[$i]->designation.'_miseEnPlace]')));
        }
        $visites->addSelect((DB::raw('(select count(*) from commandes where visite_id=visites.id ) as commande')));
        $visites->where('visites.fin', 1);
        if($de!=0&&$a!=0){
            $visites->whereBetween('visites.created_at',[$de,$a]);
        }
        if($region!='null'){
            $visites->whereIn('ugs.regionmc_id',explode(',', $region));
        }
        if($delegue!='null'){
            $visites->whereIn('visites.user_id',explode(',', $delegue));
        }
        if($ug!='null'){
            $visites->whereIn('ugmc',explode(',', $numugs));
        }

        $visites=$visites->distinct()->get();
        
        return Excel::download(new VisitesClientExportView($visites, $produits),'Visites_Pharmacies.xlsx');

    }

    public function visiteDemandes() {

        $user = Auth::user();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }
        
      //  $regions = Regionmc::Select('id','designation')->get();
        
        return view('rapports.demande',['delegues'=>$delegues]);
    }

    public function exportVisiteDemandes($de, $a,$delegues) {

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $visites = DB::table('visite_doctors')
        ->join('users','users.id','visite_doctors.user_id')
        ->join('doctors','doctors.id','visite_doctors.doctor_id')
        ->select('visite_doctors.created_at as Date','visite_doctors.id','firstname', 'lastname','doctors.name','demande_special')
        ->whereNotNull('demande_special')
        ->whereBetween('visite_doctors.created_at',[$de,$a])
        ->whereIn('visite_doctors.user_id',explode(',', $delegues))
        ->get();

        return view('rapports.rapportDemandes',['visites'=>$visites]);

    }

    public function visiteParcours() {

        $user = Auth::user();
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());

          
            $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
        }

        
        
        
        return view('rapports.parcours',['delegues'=>$delegues]);
    }

    public function exportVisiteParcours($de, $a,$delegues) {

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $visites = DB::table('visite_doctors')
        ->join('users','users.id','visite_doctors.user_id')
        ->join('doctors','doctors.id','visite_doctors.doctor_id')
        ->join('villes','doctors.ville_id','villes.id')
        ->select('visite_doctors.created_at as Date','firstname', 'lastname','doctors.name','doctors.adresse','villes.nom', DB::raw("'Médecin' as type"))
        ->whereBetween('visite_doctors.created_at',[$de,$a])
        ->whereIn('visite_doctors.user_id',explode(',', $delegues))
        ->get();

        $visites_pharmas = DB::table('visites')
        ->join('users','users.id','visites.user_id')
        ->join('clients','clients.id','visites.client_id')
        ->join('villes','clients.ville_id','villes.id')
        ->select('visites.created_at as Date','firstname', 'lastname','clients.nom as name','clients.adresse','villes.nom', DB::raw("'Pharmacie' as type"))
        ->whereBetween('visites.created_at',[$de,$a])
        ->whereIn('visites.user_id',explode(',', $delegues))
        ->get();

        return view('rapports.rapportParcours',['visites'=>$visites,'visites_pharmas'=>$visites_pharmas]);

    }

    public function visiteRupture() {

        // $ugs =   $this->ugRepository->ugsByUser(Auth::id());
        $users  = [];
        array_push($users, Auth::id());
        $networks = $this->networkRepository->getNetworksIdsByUser($users);
        $produits = $this->productRepository->productsByNetworks($networks);
        // $produits = DB::table('products')
        //     ->select('id','products.designation')
        //     ->get();

        $ugs = DB::table('ugs')
            ->select('id','ugs.designation')
            ->get();
        
        
        return view('rapports.rupture',['produits' => $produits,'ugs' => $ugs]);
    }

    public function exportVisiteRupture($de, $a, $ugs, $produits) {

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $products = DB::table('ruptures')
        ->join('visites', 'visites.id', 'ruptures.visite_id')
        ->join('clients', 'clients.id', 'visites.client_id')
        ->join('ugs', 'ugs.id', 'clients.ug_id')
        ->select((DB::raw('(select designation from products where products.id = product_id) as designation' ) ), 'ruptures.product_id as product_id', 'ruptures.product', 'ruptures.autre', 'visites.id as visite_id', 'ugs.designation as ug', 'visites.created_at as date')
        ->whereBetween('visites.created_at',[$de,$a]);
        if($ugs!='null'){
            $products->whereIn('clients.ug_id',explode(',', $ugs));
        }
        if($produits!='null'){
            $products->whereIn('ruptures.product_id',explode(',', $produits));      
        }

        $products = $products->get();

        return view('rapports.rapportRupture',['products'=>$products,'de'=>$de,'a'=>$a,'ugs'=>$ugs,'produits'=>$produits]);

    }
    public function exporter_view_visite_rupture($de, $a, $ugs, $produits){

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');

        $products = DB::table('ruptures')
        ->join('visites', 'visites.id', 'ruptures.visite_id')
        ->join('clients', 'clients.id', 'visites.client_id')
        ->join('ugs', 'ugs.id', 'clients.ug_id')
        ->select((DB::raw('(select designation from products where products.id = product_id) as designation' ) ), 'ruptures.product_id as product_id', 'ruptures.product', 'ruptures.autre', 'visites.id as visite_id', 'ugs.designation as ug', 'visites.created_at as date')
        ->whereBetween('visites.created_at',[$de,$a]);
        if($ugs!='null'){
            $products->whereIn('clients.ug_id',explode(',', $ugs));
        }
        if($produits!='null'){
            $products->whereIn('ruptures.product_id',explode(',', $produits));      
        }

        $products = $products->get();
        
        return Excel::download(new VisiteRuptureExportView($products),'Visites_Rupture.xlsx');

    }

    public function visiteAutre() {

        $specialties = DB::table('specialties')
            ->select('id','specialties.designation')
            ->get();

        $ugs = DB::table('ugs')
            ->select('id','ugs.designation')
            ->get();
        
        
        return view('rapports.autre',['specialties' => $specialties,'ugs' => $ugs]);
    }

    public function exportVisiteAutre($de, $a, $ugs, $specialties) {

        // $de = Carbon::createFromFormat('Y-m-d', $de)->format('d-m-Y');
        // $a = Carbon::createFromFormat('Y-m-d', $a)->format('d-m-Y');
        
        $autres = DB::table('visite_product_other_doctor')
        ->join('doctors', 'doctors.id', 'visite_product_other_doctor.doctor_id')
        ->join('specialties', 'specialties.id', 'doctors.specialty_id')
        ->join('visites', 'visites.id', 'visite_product_other_doctor.visite_id')
        ->join('clients', 'clients.id', 'visites.client_id')
        ->join('ugs', 'ugs.id', 'clients.ug_id')
        ->select('doctors.name',DB::raw("(select STRING_AGG(products.designation, ',') as products from visite_product_other_doctor, products  where products.id=visite_product_other_doctor.product_id and visite_product_other_doctor.doctor_id=doctors.id group by doctor_id)  as product"))
        ->distinct('doctors.id')
        ->whereBetween('visites.created_at',[$de,$a]);
        if($ugs!='null'){
            $autres->whereIn('clients.ug_id',explode(',', $ugs));
        }
        if($specialties!='null'){
            $autres->whereIn('doctors.specialty_id',explode(',', $specialties));      
        }
        $autres = $autres->get();
        
        return view('rapports.rapportAutre',['autres'=>$autres]);

    }
}