<?php

namespace App\Http\Controllers;

use App\Models\Plv;
use Illuminate\Http\Request;

class PlvController extends Controller
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
        return view('admin.plv.index', ['plvs' => Plv::all()]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plv.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plv = new Plv();
        $plv->designation = $request->input('designation');

        $plv->save();
        return redirect()->route('plvs.index')->with(['success' => 'plv ajouté ']);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plv  $plv
     * @return \Illuminate\Http\Response
     */
    public function edit(Plv $plv)
    {
        return view('admin.plv.edit', ['plv' => $plv]);  
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plv  $plv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plv $plv)
    {
        $plv->designation = $request->input('designation');
        $plv->save();
        return redirect()->route('plvs.index')->with(['success' => 'plv Modifier ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plv  $plv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plv $plv)
    {
        $plv->delete();
        return redirect()->route('plvs.index')->with(['success' => 'plv supprimé ']);
    }
}
