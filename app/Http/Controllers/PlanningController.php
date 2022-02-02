<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Planning;
use App\Repositories\NetworkRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RegionRepository;
use App\Repositories\UgRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanningController extends Controller
{ 
    
    private $ugRepository;
    private $productRepository;
    private $networkRepository;
    private $regionRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository,RegionRepository $regionRepository ,UgRepository $ugRepository ,ProductRepository $productRepository,NetworkRepository $networkRepository)
    {
        $this->middleware('auth');
        $this->middleware('can:admin.Manager+.Manager.Responsable.Delegue', ['only' => ['index', 'store',  'create',  'destroy','pharmacies','recherche','planningUser']]);

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
            return view('plannings.pharmacy.index',['delegues'=>$delegues]);

        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
            return view('plannings.pharmacy.index',['delegues'=>$delegues]);

        }
        else{
            return view('plannings.pharmacy.index_delegue');
        }

      
        
    }
    
    public function create()
    {
         $ugs = $this->ugRepository->ugsByUser(Auth::id());

        $day = date('w');
        $week_start = date('Y-m-d', strtotime('+' . (1 - $day) . ' days'));
        $week_end = date('Y-m-d', strtotime('+' . (5 - $day) . ' days'));

        $user = Auth::User();
       
        $delegues = [];
        
        if (in_array('Responsable-Delegue',$user->roles->pluck('name')->toArray())){
           array_push($delegues, DB::table('users')->where('id', Auth::Id())->first());
           $as = $this->userRepository->deleguesByUser($user->id);
            
            foreach($as as $a){
                array_push($delegues, $a);
            }
            return view('plannings.pharmacy.create', ['ugs' => $ugs, 'week_start' => $week_start, 'week_end' => $week_end,'delegues'=>$delegues]);


         }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
            return view('plannings.pharmacy.create', ['ugs' => $ugs, 'week_start' => $week_start, 'week_end' => $week_end,'delegues'=>$delegues]);
        }else{
            return view('plannings.pharmacy.create', ['ugs' => $ugs, 'week_start' => $week_start, 'week_end' => $week_end]);
        }

        
    }

    public function destroy($planning)
    {
        $planning = Planning::find($planning);
        $planning->delete();

        $client = Client::find($planning->client_id);
        $client->reserved=0;

        $client->save();
        
        // return redirect()->route('plannings.index')->with(['success' => 'Planning supprimé ']);
        return response()->json(['status' => 'Successfully deleted']);
    }

   
    public function pharmacies($id, $de, $a)
    {
       

        
        $numug = $this->ugRepository->numUgByUg(explode(',',$id));


        //dd($numug);
        $clients = DB::table('clients')
            ->select('id', 'nom', 'adresse', 'is', 'reserved', DB::raw("(select max(created_at)  as date_visite from visites where visites.client_id=clients.id)  as date_visite  ") )
            ->whereIn('ugmc', $numug)
            ->where('type',1)
            ->orderBy('date_visite')
            ->get();
 
           // dd($clients);
        return view('plannings.pharmacy.client', ['clients' => $clients, 'de' => $de, 'a' => $a]);
    }
    public function store($id, $de, $a, $delegue)
    {
        
        $de = Carbon::parse($de)->format('Y-m-d');
        $a = Carbon::parse($a)->format('Y-m-d');
        $id = explode(',', $id);
        for ($i = 0; $i < count($id); $i++) {
            $planning = new Planning();
            $planning->date_debut = $de;
            $planning->datee_fin = $a;
            $planning->client_id = $id[$i];
            $planning->user_id = $delegue;
            $planning->fait_par = Auth::id();
            $planning->save();

            $client = client::find($id[$i]);
            $client->reserved = 1;
            $client->save();
        }

        return view('plannings.pharmacy.done');
    }

    public function recherche($de, $a,$user)
    {
        
        $planning= DB::Table('plannings')
                    ->join('clients', 'clients.id', 'plannings.client_id')
                    ->select('plannings.*','clients.adresse', 'clients.nom', 'clients.is', 'clients.bloque')
                    ->where('plannings.done', 0)
                    ->where('plannings.user_id', $user)
                    ->where(function($query)use($de,$a){
                        $query->whereBetween('plannings.date_debut',[$de,$a])
                        ->orWhereBetween('plannings.datee_fin',[$de,$a]);})
                    ->orderBy('plannings.id','DESC')
                    ->get(); 
      
        return view('plannings.pharmacy.planning', ['plannings'=>$planning]);
    }

    public function error()
    {
        return view('plannings.pharmacy.error');
    }

    public function planningUser($id)
    {
        
        $plannings = DB::Table('plannings')->join('clients', 'clients.id', 'plannings.client_id')
            ->select('plannings.*','clients.adresse', 'clients.nom', 'clients.is', 'clients.bloque')
            ->where('plannings.done', 0)
            ->where('plannings.user_id', $id)
            ->orderBy('id','DESC')
            ->get();

        return view('plannings.pharmacy.planning',['plannings'=>$plannings]);
    }


    /************************************************************************** */

    public function changeUgSelect($id){
        $ugs =  $this->ugRepository->ugsByUser($id);
        return view('helpers.select',['data' => $ugs,'name'=>'ug']);
    }
    
}
