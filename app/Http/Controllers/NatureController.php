<?php

namespace App\Http\Controllers;

use App\Models\Nature;
use Illuminate\Http\Request;

class NatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin.manage',['only'=>['index','store','edit','create','update','destroy']]);

    }

    public function index()
    {
        return view('admin.nature.index', ['natures' => Nature::all()]);
    }

    public function create()
    {
        return view('admin.nature.create');
    }

    public function store(Request $request)
    {
        $nature = new Nature();
        $nature->designation = $request->input('designation');
        $nature->code_sage = $request->input('code_sage');
        $nature->save();

        return redirect()->route('natures.index')->with(['success' => 'Nature ajouté']);
    }

    public function edit(Nature $nature)
    {      
        return view('admin.nature.edit', ['nature' => $nature]);
    }

    public function update(Request $request, Nature $nature)
    {
        // dd($nature);
        //dd($request);
        $nature->designation = $request->input('designation');
        $nature->code_sage = $request->input('code_sage');
        if ($request->input('bloquer') === "1") {
            $nature->statut = (int)$request->input('bloquer');
        }else{
            $nature->statut = (int)$request->input('bloquer');
        }       
        $nature->save();

        return redirect()->route('natures.index')->with(['success' => 'Nature modifié']);
    }

    public function destroy(Nature $nature)
    {
        //
    }
}
