<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exercice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
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

        return view('admin.category.index',['categories'=>Category::with('exercice')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        // $year = Carbon::now()->format('Y');

        return view('admin.category.create');
        
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
        $yearId= Exercice::where('year',$year)->value('id');
        $validated = $request->validate([
            'designation' => 'required',
        ]);
        $category = new category();
        $category->designation = $request->input('designation');
       
        $category->exercice_id =$yearId;
        $category->save();


        return redirect()->route('categories.index');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
      
        return view('admin.category.edit',['category'=>$category]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //dd($request);
        $validated = $request->validate([
            'designation' => 'required',
        ]);
        $category->designation = $request->input('designation');
        $category->statut = (int) $request->input('bloquer');

        $category->save();
       
  
       return redirect()->route('categories.index');

    }

}
