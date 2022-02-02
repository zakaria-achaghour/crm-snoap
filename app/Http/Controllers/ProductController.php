<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Dci;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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
        return view('admin.products.index',['products'=>Product::with(['dci','dci.classe'])->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$types = Product::Products_Types;
        return view('admin.products.create',['dcis'=>Dci::all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->code_sage = $request->input('sage') ;
        $product->designation =$request->input('designation') ;
        $product->statut = (int) $request->input('statut');
        $product->dci_id = $request->input('dci');
       // $product->type = $request->input('type');

       // $product->classe_id = $request->input('classe');


        $product->save();

        
        return redirect()->route('products.index')->with(['success' => 'product ajouter ']);  

        
    }


   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
       // dd($product);
      // $types = Product::Products_Types;
        return view('admin.products.edit',['product'=>$product,'dcis'=>Dci::all()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->code_sage = $request->input('sage') ;
        $product->designation =$request->input('designation') ;
        $product->statut = (int) $request->input('statut');
        $product->dci_id = $request->input('dci');
        // $product->type = $request->input('type');

        // $product->classe_id = $request->input('classe');
        $product->save();
        return redirect()->route('products.index')->with(['success' => 'product modifier ']);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        
        $product->delete();
        return redirect()->route('products.index')->with(['success' => 'product supprimé ']);  
      }
}
