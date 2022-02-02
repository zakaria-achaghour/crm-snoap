<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NumugController extends Controller
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
        $numugs = DB::table('numugs')->get();
        
        return view('admin.numug.index', ['numugs' => $numugs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.numug.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::table('numugs')->insert(['id'=>$request->num]);
     
        return redirect()->route('numugs.index')->with(['success' => 'num  ajouté ']);
    }

 
    public function edit($id)
    {
       //dd(DB::table('numugs')->where('id',$id)->first());
        return view('admin.numug.edit', ['num' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    { 
        DB::table('numugs')
              ->where('id', $id)
              ->update(['id' => $request->num]);
        
        return redirect()->route('numugs.index')->with(['success' => 'Num mise à jour  ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       DB::table('numugs')->where('id',$id)->delete();


        return redirect()->route('numugs.index')->with(['success' => 'Numg supprimé ']);
    }
}
