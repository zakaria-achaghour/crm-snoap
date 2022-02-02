<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialtyController extends Controller
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
        $specialties = DB::table('specialties')->whereNull('deleted_at')->get();
        return view('admin.specialties.index',['specialties'=>$specialties]);
  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specialties.create');
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
        $specialty = new Specialty();
        $specialty->designation = $request->input('designation');
        $specialty->save();
        return redirect()->route('specialties.index')->with(['success' => 'specialty ajouté ']);
  
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialty $specialty)
    {
        return view('admin.specialties.edit', ['specialty' => $specialty]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialty $specialty)
    {
       // $validated = $request->validated();
        $specialty->designation = $request->input('designation');
        $specialty->save();
        return redirect()->route('specialties.index')->with(['success' => 'specialty mise à jour  ']);
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specialty  $specialty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return redirect()->route('specialties.index')->with(['success' => 'specialty supprimé ']);
   
    }
}
