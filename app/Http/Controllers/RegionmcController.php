<?php

namespace App\Http\Controllers;

use App\Http\Requests\Regionmc\RegionmcRequest;
use App\Models\Exercice;
use App\Models\Regionmc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionmcController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
         $this->middleware('can:admin.manage',['only'=>['index','store','edit','create','update','destroy']]);

    }

    public function index()
    {
        $year = Carbon::now()->format('Y');
        $yearId= Exercice::where('year',$year)->value('id');

        //$regions = DB::table('regionmcs')->where('exercice_id',$yearId)->with('exercice')->get();
        $regions = Regionmc::where('exercice_id',$yearId)->with('exercice')->get();

        return view('admin.regionMc.index', ['regions' => $regions]);
    }

    public function create()
    {
        return view('admin.regionMc.create');
    }

    public function store(RegionmcRequest $request)
    {
        $year = Carbon::now()->format('Y');
        $yearId= Exercice::where('year',$year)->value('id');
    
        $validated = $request->validated();
        $region = new Regionmc();
        $region->designation = $request->input('designation');
        $region->exercice_id = $yearId;
        $region->save();
        return redirect()->route('regionmcs.index')->with(['success' => 'region ajouté ']);
    }

  

    public function edit(Regionmc $regionmc)
    {
        return view('admin.regionMc.edit', ['region' => $regionmc]);
    }

    public function update(RegionmcRequest $request, Regionmc $regionmc)
    {
        $validated = $request->validated();
        $regionmc->designation = $request->input('designation');
        $regionmc->save();
        return redirect()->route('regionmcs.index')->with(['success' => 'region mise à jour  ']);
    }

    public function destroy(Request $request)
    {
        $region = Regionmc::findOrFail((int) $request->input('deleteregionid'));
        $region->delete();
        return redirect()->route('regionmcs.index')->with(['success' => 'region supprimé ']);
    }
}
