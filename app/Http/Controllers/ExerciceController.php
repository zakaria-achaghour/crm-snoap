<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ExerciceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin.manage',['only'=>['index','store','edit','create','update','destroy']]);

    }
    public function index()
    {

        return view('admin.exercice.index',['exercices'=>Exercice::orderByDesc('year')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $year = Carbon::now()->format('Y');

        return view('admin.exercice.create',['year'=>$year-1]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $year = Carbon::now()->format('Y');
        $validated = $request->validate([
            'year' => 'required|gte:'.$year,
        ]);
        $exercice = new Exercice();
        $exercice->year = $request->input('year');
        $exercice->save();


        return redirect()->route('exercices.index');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Exercice  $exercice
     * @return \Illuminate\Http\Response
     */
    public function edit(Exercice $exercice)
    {
        $year = Carbon::now()->format('Y');
        return view('admin.exercice.edit',['year'=>$year,'exercice'=>$exercice]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exercice  $exercice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exercice $exercice)
    {
     
        $exercice->statut = (int)$request->input('bloquer');
      
        $exercice->save();
         /** set all the familles in the inventory */
       
        //  $year = Carbon::now()->format('Y');
        //  $inventoryDate = Carbon::createFromFormat('d/m/Y', '31/12/'.$year);
        //  if($inventoryDate->isToday()){
            
  
       return redirect()->route('exercices.index');

    }

    
}
