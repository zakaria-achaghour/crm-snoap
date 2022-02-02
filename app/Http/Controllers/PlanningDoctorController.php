<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\PlanningDoctor;
use App\Repositories\NetworkRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RegionRepository;
use App\Repositories\UgRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanningDoctorController extends Controller
{
   private $ugRepository;
   private $productRepository;
   private $networkRepository;
   private $regionRepository;
   private $userRepository;

   public function __construct(UserRepository $userRepository,RegionRepository $regionRepository ,UgRepository $ugRepository ,ProductRepository $productRepository,NetworkRepository $networkRepository)
   {
       $this->middleware('auth');
       $this->middleware('can:admin.Manager+.Manager.Responsable.Delegue', ['only' => ['index', 'store',  'create',  'destroy','doctors','recherche','planningUser']]);

       $this->ugRepository = $ugRepository;
       $this->productRepository = $productRepository;
       $this->networkRepository = $networkRepository;
       $this->regionRepository = $regionRepository;
       $this->userRepository = $userRepository;

   }
    //     start doctors function  
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
            return view('plannings.doctors.index',['delegues'=>$delegues]);
        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
            return view('plannings.doctors.index',['delegues'=>$delegues]);
        }
        else{
            return view('plannings.doctors.index_delegue');
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
            return view('plannings.doctors.create', ['ugs' => $ugs, 'week_start' => $week_start, 'week_end' => $week_end,'delegues'=>$delegues]);

        }else if(in_array('admin', $user->roles->pluck('name')->toArray())
                || in_array('Manager', $user->roles->pluck('name')->toArray())
                || in_array('Manager+', $user->roles->pluck('name')->toArray())){

            $delegues = $this->userRepository->delegues();
            return view('plannings.doctors.create', ['ugs' => $ugs, 'week_start' => $week_start, 'week_end' => $week_end,'delegues'=>$delegues]);

        }
        else{
            return view('plannings.doctors.create', ['ugs' => $ugs, 'week_start' => $week_start, 'week_end' => $week_end]);

        }
        
    }
    // is existe or not 
    // reserved 
    public function doctors($id, $de, $a)
    {
        $doctors = DB::table('doctors')
            ->join('specialties', 'specialties.id', 'doctors.specialty_id')
            ->select('doctors.id', 'specialties.designation','doctors.statut_mc', 'doctors.name', 'doctors.adresse','doctors.reserved', DB::raw("(select max(created_at)  as date_visite from visite_doctors where visite_doctors.doctor_id=doctors.id)  as date_visite  ") )
            ->where('doctors.ug_id', $id)
            ->orderBy('date_visite')
            ->get();
        return view('plannings.doctors.doctor', ['doctors' => $doctors, 'de' => $de, 'a' => $a]);
    }

    public function store($id, $de, $a, $delegue) {

        
        $de = Carbon::parse($de)->format('Y-m-d');
        $a = Carbon::parse($a)->format('Y-m-d');

        $id = explode(',', $id);
        for ($i = 0; $i < count($id); $i++) {
            $planning = new PlanningDoctor();
            $planning->date_debut = $de;
            $planning->datee_fin = $a;
            $planning->doctor_id = $id[$i];
            $planning->user_id = $delegue;
            $planning->fait_par = Auth::id();
            $planning->save();

            $doctor = Doctor::find($id[$i]);
            $doctor->reserved = 1;
            $doctor->save();
        }

        return view('plannings.doctors.done');
    }

    public function recherche($de, $a,$user)
    {
        
        $planning= DB::Table('planning_doctors')
                    ->join('doctors', 'doctors.id', 'planning_doctors.doctor_id')
                    ->join('specialties', 'specialties.id', 'doctors.specialty_id')
                    ->select('planning_doctors.*', 'specialties.designation', 'doctors.statut_mc','doctors.adresse', 'doctors.name', 'doctors.deleted_at')
                    ->where('planning_doctors.done', 0)
                    ->where('planning_doctors.user_id', $user)
                    ->where(function($query)use($de,$a){
                        $query->whereBetween('planning_doctors.date_debut',[$de,$a])
                        ->orWhereBetween('planning_doctors.datee_fin',[$de,$a]);})
                    ->orderBy('planning_doctors.id','DESC')
                    ->get(); 

        $visites = DB::table('planning_doctors')->select(
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id!=22 and planning_doctors.user_id='$user' and planning_doctors.created_at between '$de' and '$a' and planning_doctors.done=0 ) as ps"),
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id=22 and planning_doctors.user_id='$user' and planning_doctors.created_at between '$de' and '$a' and planning_doctors.done=0  ) as pg"),
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id!=22 and planning_doctors.user_id='$user' and planning_doctors.created_at between '$de' and '$a' and planning_doctors.done=0 ) as hs"),
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id=22 and planning_doctors.user_id='$user' and planning_doctors.created_at between '$de' and '$a' and planning_doctors.done=0 ) as hg")
        )->limit(1)->get();
        
        $dataset = [];

        
        array_push($dataset, $visites[0]->ps);
        array_push($dataset, $visites[0]->pg);
        array_push($dataset, $visites[0]->hs);
        array_push($dataset, $visites[0]->hg);

        return view('plannings.doctors.planning', ['plannings'=>$planning,'statistique'=>$dataset]);
    }

    public function planningUser($id)
    {
        // dd($id);
        $plannings = DB::Table('planning_doctors')
            ->join('doctors', 'doctors.id', 'planning_doctors.doctor_id')
            ->join('specialties', 'specialties.id', 'doctors.specialty_id')
            ->select('planning_doctors.*','doctors.adresse', 'doctors.statut_mc', 'specialties.designation', 'doctors.name',  'doctors.deleted_at')
            ->where('planning_doctors.done', 0)
            ->where('planning_doctors.user_id', $id)
            ->orderBy('id','DESC')
            ->get();

            // dd($plannings);

        $visites = DB::table('planning_doctors')->select(
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id!=22 and planning_doctors.user_id='$id' and planning_doctors.done=0 ) as ps"),
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PRIVE' and specialty_id=22 and planning_doctors.user_id='$id' and planning_doctors.done=0  ) as pg"),
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id!=22 and planning_doctors.user_id='$id' and planning_doctors.done=0 ) as hs"),
            DB::raw("(select count(*) from planning_doctors ,doctors  where  planning_doctors.doctor_id =doctors.id and doctors.statut_mc='PUBLIC' and specialty_id=22 and planning_doctors.user_id='$id' and planning_doctors.done=0 ) as hg")
        )->limit(1)->get();
        
        $dataset = [];

    
        array_push($dataset, $visites[0]->ps);
        array_push($dataset, $visites[0]->pg);
        array_push($dataset, $visites[0]->hs);
        array_push($dataset, $visites[0]->hg);


        return view('plannings.doctors.planning',['plannings'=>$plannings,'statistique'=>$dataset]);
    }

    public function destroy($planning)
    {
        $planning = PlanningDoctor::find($planning);
        $planning->delete();
        $doctor = Doctor::find($planning->doctor_id);
        $doctor->reserved=0;
        $doctor->save();
        
        // return redirect()->route('plannings.index')->with(['success' => 'Planning supprimé ']);
        return response()->json(['status' => 'Successfully deleted']);
    }
}