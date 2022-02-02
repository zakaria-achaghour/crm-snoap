<?php

namespace App\Http\Controllers;

use App\Models\Limite;
use App\Models\Role;
use Illuminate\Http\Request;

class LimiteController extends Controller
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
         $limites =  Limite::with('user')->get();
        // dd($limites);
        return view('limites.index',['limites'=>$limites]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $delegues = Role::where('name','delegue')->first()->users;

        return view('limites.create',['delegues'=>$delegues]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $limite = new Limite();
        $limite->user_id = $request->delegue;
        $limite->visite_prive = $request->nbPrive;
        $limite->visite_public = $request->nbPublic;
        $limite->save();

        return redirect()->route('limites.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Limite $limite)
    {
      
        $delegues = Role::where('name','delegue')->first()->users;

        return view('limites.edit',['delegues'=>$delegues,'limite'=>$limite]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Limite $limite)
    {
        $limite->user_id = $request->delegue;
        $limite->visite_prive = $request->nbPrive;
        $limite->visite_public = $request->nbPublic;
        $limite->save();

        return redirect()->route('limites.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
