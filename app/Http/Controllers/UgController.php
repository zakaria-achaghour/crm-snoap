<?php

namespace App\Http\Controllers;

use App\Models\Regionmc;
use App\Models\Ug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UgController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
         $this->middleware('can:admin.manage',['only'=>['index','store','edit','create','update','destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $ugs = DB::table('ugs')->get();

       $ugs = Ug::leftjoin('regionmcs','regionmcs.id','ugs.regionmc_id')
       ->select('ugs.id','ugs.designation','regionmcs.designation as regionmc','ugs.statut')->get();
       //dd($ugs);
        return view('admin.ug.index', ['ugs' => $ugs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regionmcs = Regionmc::all();
        $numugs = DB::table('numugs')->select('id')->get();

        return view('admin.ug.create',['regionmcs'=>$regionmcs,'numugs'=>$numugs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $ug = new Ug();
        $ug->designation = $request->input('designation');
        $ug->regionmc_id = $request->input('regionmc');
        $ug->save();
        //DB::table('user_regionmc_network')->where('user_id', $user->id)->delete();


        for ($i = 0; $i < count($request->num); $i++) {
            DB::table('ug_numug')->insert(['ug_id'=>$ug->id,'num_ug'=>$request->num[$i]]);
        }
  
        return redirect()->route('ugs.index')->with(['success' => 'Ug ajouté ']);
    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ug  $ug
     * @return \Illuminate\Http\Response
     */
    public function edit(Ug $ug)
    {
       // dd($ug);
        $regionmcs = Regionmc::all();
        $numsTab = [];
        $nums = DB::table('ugs')->join('ug_numug','ug_numug.ug_id','ugs.id')
        ->select('num_ug')->where('ugs.id',$ug->id)->get();

        for ($i=0; $i <count($nums) ; $i++) { 
            array_push($numsTab,$nums[$i]->num_ug);
        }
    
        $numugs = DB::table('numugs')->select('id')->get();
        return view('admin.ug.edit', ['ug' => $ug,'regionmcs'=>$regionmcs,'numugs'=>$numugs,'nums'=>$numsTab]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ug  $ug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ug $ug)
    {
        $ug->designation = $request->input('designation');
         $ug->regionmc_id = $request->input('regionmc');
          $ug->statut = (int)$request->input('bloquer');
       
        $ug->save();
         DB::table('ug_numug')->where('ug_id', $ug->id)->delete();


         for ($i = 0; $i < count($request->num); $i++) {
            DB::table('ug_numug')->insert(['ug_id'=>$ug->id,'num_ug'=>$request->num[$i]]);
        }
     

        return redirect()->route('ugs.index')->with(['success' => 'UG Modifier ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ug  $ug
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ug $ug)
    {
       
        $ug->delete();
        return redirect()->route('ugs.index')->with(['success' => 'UG supprimé ']);
    }


   
}
