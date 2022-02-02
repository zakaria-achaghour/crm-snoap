<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Models\Regionmc;
use App\Models\UserResponsable;
use App\Models\Role;
use App\Models\Ug;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin.manage', ['only' => ['index', 'store', 'edit', 'create', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Famille::all()->pluck('id')->toArray());
        $users = User::with(['roles'])->get();
      
       // dd($users);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

     
        $roles = Role::whereIn('name', ['Responsable-Delegue','Manager','Manager+','admin'])->get();
        
        $responsables = [];
        foreach($roles as $role){
            foreach($role->users as $user){
                array_push($responsables,$user);
            }
            
        } 

        // $nugs = DB::table('network_ug_regionmcs')
        //             ->join('regionmcs','regionmcs.id','network_ug_regionmcs.regionmc_id') 
        //             ->join('networks','networks.id','network_ug_regionmcs.network_id') 
        //             ->join('ugs','ugs.id','network_ug_regionmcs.ug_id') 
        //             ->select('network_ug_regionmcs.id','regionmcs.designation as regionmc','networks.designation as network','ugs.designation as ug')
        //             ->get();
        $rns = DB::table('regionmc_networks')
        ->join('regionmcs','regionmcs.id','regionmc_networks.regionmc_id') 
        ->join('networks','networks.id','regionmc_networks.network_id') 
        ->select('regionmc_networks.id','regionmcs.designation as regionmc','networks.designation as network')
        ->whereNull('regionmc_networks.deleted_at')
        ->get();
                // foreach ($nugs as $nug) {
                //     dd($nug);
                // }
             

                $ugs = Ug::all();
        return view('admin.users.create', ['roles' => Role::all(), 'rns' => $rns, 'responsables' => $responsables,'ugs'=>$ugs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        // dd($request->all());

        $user = new User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->contact = $request->input('contact');
        $user->gender = $request->input('gender');
        $user->username = $request->input('firstname')[0] . '.' . $request->input('lastname');
        $user->password = Hash::make('password');
     

        $user->save();


        $user->roles()->sync($request->roles);

        if($request->ugs[0]==='all'){
            $ugs = Ug::select('id')->get();
            $ugIds = [];
            foreach ($ugs as $ug) {
                array_push($ugIds,$ug->id);
            }
            $user->ugs()->sync($ugIds);
        }else{

            $user->ugs()->sync($request->ugs);
        }

    
        if($request->rns[0] ==='all') {
            $rns = DB::table('regionmc_networks')
            ->join('regionmcs','regionmcs.id','regionmc_networks.regionmc_id') 
            ->join('networks','networks.id','regionmc_networks.network_id') 
            ->select('regionmc_networks.id','regionmcs.designation as regionmc','networks.designation as network')
            ->whereNull('regionmc_networks.deleted_at')
            ->get();

            for ($i = 0; $i < count($rns); $i++) {
                DB::table('user_regionmc_network')->insert(['user_id' => $user->id, 'regionmc_network_id' => $rns[$i]->id]);
            }
        }else{
            if($request->rns!=Null){

                for ($i = 0; $i < count($request->rns); $i++) {
                    DB::table('user_regionmc_network')->insert(['user_id' => $user->id, 'regionmc_network_id' => $request->rns[$i]]);
                }
            }
        }
        // $user->nugs()->sync($request->nugs);
        
        if($request->responsable!=Null){
        $responsables = $request->responsable;
        

      
        for($i=0; $i<count($responsables);$i++){
            $userResp = new UserResponsable();

            $userResp->user_id = $user->id;
            $userResp->responsable_id =$responsables[$i]; 
            $userResp->save();
        }
    }


        return redirect()->route('users.index')->with(['success' => 'User added']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user =  User::findOrFail($id);
     //dd($user);
       // dd($user->userResponsables->pluck('responsable_id')->contains(2));
        $roles = Role::whereIn('name', ['Responsable-Delegue','Manager','Manager+','admin'])->get();
        
        $responsables = [];
        foreach($roles as $role){
            foreach($role->users as $u){
                array_push($responsables,$u);
            }
            
        }
        
        
       // dd($user->nugs);
        $role = Role::where('name', 'Responsable-Delegue')->with(['users'])->first();
        // $nugs = DB::table('network_ug_regionmcs')
        //             ->join('regionmcs','regionmcs.id','network_ug_regionmcs.regionmc_id') 
        //             ->join('networks','networks.id','network_ug_regionmcs.network_id') 
        //             ->join('ugs','ugs.id','network_ug_regionmcs.ug_id') 
        //             ->select('network_ug_regionmcs.id','regionmcs.designation as regionmc','networks.designation as network','ugs.designation as ug')
        //             ->get();
        $rns = DB::table('regionmc_networks')
        ->join('regionmcs','regionmcs.id','regionmc_networks.regionmc_id') 
        ->join('networks','networks.id','regionmc_networks.network_id') 
        ->select('regionmc_networks.id','regionmcs.designation as regionmc','networks.designation as network')
        ->whereNull('regionmc_networks.deleted_at')
        ->get();

        $ugs = Ug::all();

        return view('admin.users.edit', ['user' => $user, 'roles' => Role::all(), 'rns' => $rns, 'responsables' => $responsables,'ugs'=>$ugs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //dd($request->all());

        $date = Carbon::now()->format('d-m-Y H:i:s');

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->contact = $request->input('contact');
        $user->gender = $request->input('gender');
        $user->username = $request->input('firstname')[0] . '.' . $request->input('lastname');

        // $user->responsable_id = (int) $request->input('responsable');

        $user->save();
        $user->roles()->sync($request->roles);
        if($request->ugs[0]==='all'){
            $ugs = Ug::select('id')->get();
            $ugIds = [];
            foreach ($ugs as $ug) {
                array_push($ugIds,$ug->id);
            }
            $user->ugs()->sync($ugIds);
        }else{

            $user->ugs()->sync($request->ugs);
        }


        // $user->nugs()->sync($request->nugs);
       // dd($request->rns[0]);
        if($request->rns[0] ==='all') {
            $rns = DB::table('regionmc_networks')
            ->join('regionmcs','regionmcs.id','regionmc_networks.regionmc_id') 
            ->join('networks','networks.id','regionmc_networks.network_id') 
            ->select('regionmc_networks.id','regionmcs.designation as regionmc','networks.designation as network')
            ->whereNull('regionmc_networks.deleted_at')
            ->get();

            DB::table('user_regionmc_network')->where('user_id', $user->id)->delete();


            for ($i = 0; $i < count($rns); $i++) {
                DB::table('user_regionmc_network')->insert(['user_id' => $user->id, 'regionmc_network_id' => $rns[$i]->id]);
            }
        }else{
            if($request->rns!=Null){

                DB::table('user_regionmc_network')->where('user_id', $user->id)->delete();

                for ($i = 0; $i < count($request->rns); $i++) {
                    DB::table('user_regionmc_network')->insert(['user_id' => $user->id, 'regionmc_network_id' => $request->rns[$i]]);
                }
            }
        }


     

        DB::table('user_responsables')->where('user_id',$user->id)->delete();


        if($request->responsable!=Null){
            $responsables = $request->responsable;

            for($i=0; $i<count($responsables);$i++){
                $userResp = new UserResponsable();

                $userResp->user_id = $user->id;
                $userResp->responsable_id =$responsables[$i]; 
                $userResp->save();
            }
    }

        return redirect()->route('users.index')->with(['success' => 'User Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
       // Responsable::where('user_id',$id)->delete();
       DB::table('user_responsables')->where('user_id',$id)->delete();


        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => "Error",
            ]);
        }
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => "Utilisateur Bloqué avec succès",
        ]);
    }


    public function restore($id)
    {

        $user = User::onlyTrashed()->where('id', $id)->first();
        $user->restore();
      //  Responsable::onlyTrashed()->where('user_id',$id)->restore();

        return redirect()->back();
    }


    public function resetPassword($id)
    {


        $user = User::findOrFail($id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => "Error",
            ]);
        }
        $user->password = Hash::make('password');
        $user->save();
        return response()->json([
            'success' => true,
            'message' => "Mot de Passe Réinitialiser avec succès",
        ]);
    }




    public function animateurs()
    {
        
        $role = Role::where('name', 'Animateur')->with(['users'])->first();
        $users = DB::table('users')
            ->Join('role_user', 'role_user.user_id',  'users.id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->select('users.firstname', 'users.lastname', 'users.email', 'users.contact')
            ->where('roles.name', 'Animateur')
            ->get();
        dd($users);

        return view('admin.ligneToAnimateur.animateurs', ['users' => $role->users]);
    }

    public function editAnimateurs()
    {
        // $userId = Auth::id();

        // $users = User::where('responsable_id',$userId)->get();
        $role = Role::where('name', 'Animateur')->with(['users'])->first();


        return view('admin.ligneToAnimateur.animateurs', ['users' => $role->users]);
    }


    // public function editAffecterAnimateurToResponsable(User $user)
    // {

    //     $role = Role::where('name','Animateur')->with(['users'])->first();


    //     //$animateurs = Role::where('name','Animateurs')->users()->get();

    //     return view('admin.animateurToResponsable.affecter', ['user' => $user,'animateurs'=>$role->users]);
    // }

    // public function UpdateAffecterAnimateurToResponsable(User $user,Request $request)
    // {



    //     return redirect()->route('users.AffecterAnimateurToResponsableIndex');
    // }
}
