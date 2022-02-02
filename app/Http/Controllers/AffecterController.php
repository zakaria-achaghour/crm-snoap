<?php

namespace App\Http\Controllers;


use App\Models\Exercice;
use App\Models\Network;
use App\Models\NetworkUgRegionmc;
use App\Models\Region;
use App\Models\Regionmc;
use App\Models\Ug;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AffecterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin.manage', ['only' => ['index', 'affecterRegionResauxUg', 'storeAffecter', 'destroy']]);

   }
    public function index(){

        // $rrus = Network::witdh('ug')->get();
        // $rrus = DB::table('network_ug_regionmcs')
        // ->join('regionmcs','regionmcs.id','network_ug_regionmcs.regionmc_id') 
        // ->join('networks','networks.id','network_ug_regionmcs.network_id') 
        // ->join('ugs','ugs.id','network_ug_regionmcs.ug_id') 
        // ->select('network_ug_regionmcs.id','regionmcs.designation as regionmc','networks.designation as network','ugs.designation as ug')
        // ->groupBy('network_ug_regionmcs.id','networks.designation','regionmcs.designation','ugs.designation')
        // ->get();

        $rns = DB::table('regionmc_networks')
                  ->join('regionmcs','regionmcs.id','regionmc_networks.regionmc_id') 
                  ->join('networks','networks.id','regionmc_networks.network_id') 
                  ->select('regionmc_networks.id','regionmcs.designation as regionmc','networks.designation as network')
                  ->whereNull('regionmc_networks.deleted_at')
                  ->get();
        return view('admin.affecterRegionResauxUg.index',['rns'=>$rns]);
    }

    public function affecterRegionResauxUg(){
        $year = Carbon::now()->format('Y');
        $yearId= Exercice::where('year',$year)->value('id');

        $networks = Network::all();
        $regionmcs = Regionmc::where('exercice_id',$yearId)->get();

        

        return view('admin.affecterRegionResauxUg.create',['regionmcs'=>$regionmcs,'networks'=>$networks]);
    }

    public function storeAffecter(Request $request){

       
       // dd($request->all());
        // for ($i=0; $i <count($request->ugs) ; $i++) { 
        //     $nug = new NetworkUgRegionmc();
        //     $nug->network_id = $request->network;
        //     $nug->ug_id = $request->ugs[$i];
        //     $nug->regionmc_id = $request->regionmc;
          

        //     $nug->save();
        // }

        $regionmc = Regionmc::find($request->regionmc);
        $regionmc->networks()->sync($request->networks);
        return redirect()->route('affecter.index');
    }

    public function destroy($id){

       // DB::table('regionmc_network')->where('id',$id)->delete();
        DB::table('regionmc_networks')->where('id', $id)->update(['deleted_at' => Carbon::now()]);
        return redirect()->route('affecter.index');
    }
}
