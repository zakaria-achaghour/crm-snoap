<?php

namespace App\Http\Controllers;

use App\Http\Requests\fournisseur\FournisseurRequest;
use App\Models\Article;
use App\Models\Articles_fournisser;
use App\Models\Fournisseur;
use App\Models\Ville;
use Illuminate\Http\Request;

class FournisseurController extends Controller
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
        return view('admin.fournisseur.index', ['fournisseurs' => Fournisseur::with('ville')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $villes = Ville::select('id','nom')->get();
       
        return view('admin.fournisseur.create',['villes'=>$villes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FournisseurRequest $request)
    {
      //  dd($request->all());
        
        $fournisseur = new Fournisseur();
        $fournisseur->designation = $request->input('designation');
        $fournisseur->code_sage = $request->input('code_sage');
        $fournisseur->ville_id = $request->input('ville');

        $fournisseur->save();

        return redirect()->route('fournisseurs.index')->with(['success' => 'Fournisseur ajouté ']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit(Fournisseur $fournisseur)
    {
        $villes = Ville::select('id','nom')->get();

      
        return view('admin.fournisseur.edit', ['fournisseur' => $fournisseur,'villes'=>$villes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(FournisseurRequest $request, Fournisseur $fournisseur)
    {
        // dd($fournisseur);
        //dd($request);
        $fournisseur->designation = $request->input('designation');
        $fournisseur->code_sage = $request->input('code_sage');
        if ($request->input('bloquer') === "1") {
            $fournisseur->statut = (int)$request->input('bloquer');
            $fournisseur->motif = $request->input('motif');
        }else{
            $fournisseur->statut = (int)$request->input('bloquer');
            $fournisseur->motif = "";
        }
        $fournisseur->ville_id = $request->input('ville');
       
        $fournisseur->save();
       

        return redirect()->route('fournisseurs.index')->with(['success' => 'Fournisseur modifié ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fournisseur $fournisseur)
    {
        //
    }
}
