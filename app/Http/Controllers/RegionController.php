<?php

namespace App\Http\Controllers;

use App\Http\Requests\region\RegionRequest;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RegionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
         $this->middleware('can:admin.manage',['only'=>['index','store','edit','create','update','destroy']]);

    }

    public function index()
    {
        $regions = DB::table('regions')->get();

        return view('admin.regions.index', ['regions' => $regions]);
    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function store(RegionRequest $request)
    {
    
        $validated = $request->validated();
        $region = new Region();
        $region->nom = $request->input('nom');
        $region->save();
        return redirect()->route('regions.index')->with(['success' => 'region ajouté ']);
    }

    public function show(Region $region)
    {
        //
    }

    public function edit(Region $region)
    {
        return view('admin.regions.edit', ['region' => $region]);
    }

    public function update(RegionRequest $request, Region $region)
    {
        $validated = $request->validated();
        $region->nom = $request->input('nom');
        $region->save();
        return redirect()->route('regions.index')->with(['success' => 'region mise à jour  ']);
    }

    public function destroy(Request $request)
    {
        $region = Region::findOrFail((int) $request->input('deleteregionid'));
        $region->delete();
        return redirect()->route('regions.index')->with(['success' => 'region supprimé ']);
    }
}
