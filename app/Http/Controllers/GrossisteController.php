<?php

namespace App\Http\Controllers;

use App\Models\Grossiste;
use App\Models\Ville;
use Illuminate\Http\Request;

class GrossisteController extends Controller
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
        
        $grossistes = Grossiste::with('ville')->get();
        
        return view('admin.grossiste.index', ['grossistes' => $grossistes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $villes = Ville::select('id','nom')->get();
        return view('admin.grossiste.create', ['villes' => $villes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $validated = $request->validated();

        $grossiste = new Grossiste();
        $grossiste->designation = $request->input('designation');
        $grossiste->ville_id = $request->input('ville');
        $grossiste->save();

        return redirect()->route('grossistes.index')->with(['success' => 'grossiste ajouté ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grossiste  $grossiste
     * @return \Illuminate\Http\Response
     */
    public function show(Grossiste $grossiste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grossiste  $grossiste
     * @return \Illuminate\Http\Response
     */
    public function edit(Grossiste $grossiste)
    {
        $villes = Ville::select('id','nom')->get();
        return view('admin.grossiste.edit', ['villes' => $villes,'grossiste'=>$grossiste]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grossiste  $grossiste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grossiste $grossiste)
    {
        $grossiste->designation = $request->input('designation');
        $grossiste->ville_id = $request->input('ville');
        $grossiste->save();

        return redirect()->route('grossistes.index')->with(['success' => 'grossiste ajouté ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grossiste  $grossiste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grossiste $grossiste)
    {
        
     $grossiste->delete();


     return redirect()->route('grossistes.index')->with(['success' => 'grossiste supprimé ']);
    }
}
