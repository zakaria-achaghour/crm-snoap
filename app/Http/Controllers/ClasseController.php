<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Product;
use Illuminate\Http\Request;

class ClasseController extends Controller
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
        return view('admin.classe.index', ['classes' => Classe::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Product::Products_Types;
        

       
        return view('admin.classe.create',['types'=>$types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classe = new Classe();
        $classe->designation = $request->input('designation');
        $classe->type = $request->input('type');
        $classe->save();
        return redirect()->route('classes.index')->with(['success' => 'classe ajouté ']);
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function edit(Classe $class)
    {
        $types = Product::Products_Types; 
        return view('admin.classe.edit', ['classe' => $class,'types'=>$types]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classe $class)
    {
        // dd($request);
        $class->designation = $request->input('designation');
        $class->type = $request->input('type');
        $class->save();
        return redirect()->route('classes.index')->with(['success' => 'classe Modifier ']);
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classe  $classe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('classes.index')->with(['success' => 'classe supprimé ']);
    }
}
