<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\dci;
use Illuminate\Http\Request;

class dciController extends Controller
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
        
        return view('admin.dci.index', ['dcis' => Dci::with(['classe'])->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dci.create',['classes'=>Classe::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dci = new Dci();
        $dci->designation = $request->input('designation');
        $dci->classe_id = $request->input('classe');
        $dci->save();
        return redirect()->route('dcis.index')->with(['success' => 'dci ajouté ']);
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dci  $dci
     * @return \Illuminate\Http\Response
     */
    public function edit(Dci $dci)
    {
        return view('admin.dci.edit', ['dci' => $dci,'classes'=>Classe::all()]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dci  $dci
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dci $dci)
    {
        $dci->designation = $request->input('designation');
        $dci->classe_id = $request->input('classe');

        
        $dci->save();
        return redirect()->route('dcis.index')->with(['success' => 'dci Modifier ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dci  $dci
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dci $dci)
    {
        $dci->delete();
        return redirect()->route('dcis.index')->with(['success' => 'dci supprimé ']);
    }
}
