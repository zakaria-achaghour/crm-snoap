<?php

namespace App\Http\Controllers;

use App\Http\Requests\Doctor\DoctorRequest;
use App\Http\Requests\Doctor\DoctorupdateRequest;
use App\Models\Doctor;
use App\Models\Region;
use App\Models\Regionmc;
use App\Models\Specialty;
use App\Models\Ug;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
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
        $doctors = DB::table('doctors')
        ->join('villes','villes.id','doctors.ville_id')    
        ->join('regionmcs','regionmcs.id','doctors.region_id')    
         ->join('ugs','ugs.id','doctors.ug_id')    
        ->join('specialties','specialties.id','doctors.specialty_id')
        ->select('doctors.id','doctors.name','doctors.nombre_patients','doctors.phone','doctors.adresse','doctors.statut_mc','villes.nom as ville','specialties.designation as specialty','regionmcs.designation as region','ugs.designation as ug')
        ->whereNull('doctors.deleted_at')
        ->get();  

        // dd($doctors);
        return view('admin.doctor.index',['doctors'=>$doctors]);  

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $villes = Ville::all();
        $specialties = Specialty::all();
        $ugs = Ug::all();
        $regions = Regionmc::all();

        return view('admin.doctor.create',['villes'=>$villes,'specialties'=> $specialties,'regions'=>$regions,'ugs'=>$ugs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {
       // dd((int)$request->phone);
        $doctor = new Doctor();
        $doctor->name = $request->name;
        $doctor->phone = (int)$request->phone;
        $doctor->ville_id = $request->ville;
        $doctor->ug_id = $request->ug;
        $doctor->region_id = $request->region;
        $doctor->specialty_id = $request->specialty;
        $doctor->adresse = $request->adresse;
        $doctor->nombre_patients = $request->nombre_patients;
        $doctor->statut_mc = $request->statut;
        $doctor->save();
        return redirect()->route('doctors.index');

    }

  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        $villes = Ville::all();
        $specialties = Specialty::all();
        $ugs = Ug::all();
        $regions = Regionmc::all();

        return view('admin.doctor.edit',['doctor'=>$doctor,'villes'=>$villes,'specialties'=> $specialties,'regions'=>$regions,'ugs'=>$ugs]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorupdateRequest $request, Doctor $doctor)
    {
        // dd($request->all());

        $doctor->name = $request->name;
        $doctor->phone = (int)$request->phone;
        $doctor->ville_id = $request->ville;
        $doctor->ug_id = $request->ug;
        $doctor->region_id = $request->region;
        $doctor->specialty_id = $request->specialty;

        $doctor->adresse = $request->adresse;
        $doctor->nombre_patients = $request->nombre_patients;
        $doctor->statut_mc = $request->statut;

        $doctor->save();
        return redirect()->route('doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }

 
}
