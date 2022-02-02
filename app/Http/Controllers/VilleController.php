<?php

namespace App\Http\Controllers;

use App\Http\Requests\ville\VilleRequest;
use App\Http\Requests\ville\VilleupdateRequest;
use App\Models\Region;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VilleController extends Controller
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
        $villes = DB::table('villes')->where('deleted_at',null)->get();
        
        return view('admin.villes.index', ['villes' => $villes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = DB::table('regions')->get();
        return view('admin.villes.create', ['regions' => $regions]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VilleRequest $request)
    {
        // dd($request);

        $validated = $request->validated();

        $ville = new Ville();
        $ville->nom = $request->input('nom');
        $ville->region_id = $request->input('region');
        $ville->save();

        return redirect()->route('villes.index')->with(['success' => 'Ville ajouté ']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function show(Ville $ville)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function edit(Ville $ville)
    {
        $regions = Region::all();
        return view('admin.villes.edit', ['ville' => $ville, 'regions' => $regions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function update(VilleupdateRequest $request, Ville $ville)
    { 
        //dd($ville);
        //dd($request);
        $validated = $request->validated();
        $ville->nom = $request->input('nom');
        $ville->region_id = (int)$request->input('region');
        $ville->save();
        return redirect()->route('villes.index')->with(['success' => 'Ville mise à jour  ']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ville  $ville
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ville = Ville::findOrFail((int) $request->input('deleteVilleid'));
   

     $ville->delete();


        return redirect()->route('villes.index')->with(['success' => 'Ville supprimé ']);
    }
}
