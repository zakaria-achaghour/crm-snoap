<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ligne\ResauxRequest;
use App\Http\Requests\Ligne\UpdateResauxRequest;
use App\Models\Category;
use App\Models\Exercice;
use App\Models\Network;
use App\Models\Plv;
use App\Models\Product;
use App\Models\Regionmc;
use App\Models\Ug;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
         $this->middleware('can:admin.manage',['only'=>['index','store','edit','create','update','destroy']]);

    }

    public function index()
    {
        //$lignes = DB::table('lignes')->get();

        $networks = Network::with(['category','products','plvs'])->get();
        
        return view('admin.resaux.index', ['networks' => $networks]);
    }

    public function create()
    {  $year = Carbon::now()->format('Y');
        $yearId= Exercice::where('year',$year)->value('id');

        $cat = Category::where('exercice_id',$yearId)->get();
        $regionmcs = Regionmc::where('exercice_id',$yearId)->get();

        $ugs = Ug::all();
        $products = Product::all();
        $plvs = Plv::all();


        return view('admin.resaux.create',['categories'=>$cat,'regionmcs'=>$regionmcs,'ugs'=>$ugs,'products'=>$products,'plvs'=>$plvs]);
    }

    public function store(ResauxRequest $request)
    {
    
        $validated = $request->validated();
        $network = new Network();
        $network->designation = $request->input('designation');
        $network->category_id = (int) $request->input('category');
        
        $network->save();
        
        $network->products()->sync($request->products);
        $network->plvs()->sync($request->plvs);


        return redirect()->route('resaux.index')->with(['success' => 'resaux ajouté ']);
    }

   

    public function edit(Network $resaux)
    {
        $year = Carbon::now()->format('Y');
        $yearId= Exercice::where('year',$year)->value('id');

        $cat = Category::where('exercice_id',$yearId)->get();
        $products = Product::all();
        $plvs = Plv::all();

        return view('admin.resaux.edit', ['network' => $resaux,'categories'=>$cat,'products'=>$products,'plvs'=>$plvs]);
    }

    public function update(Request $request, Network $resaux)
    {
        //dd($resaux);
        $resaux->designation = $request->designation;
        $resaux->category_id = (int) $request->category;

        $resaux->save();
        $resaux->products()->sync($request->products);
        $resaux->plvs()->sync($request->plvs);

        return redirect()->route('resaux.index')->with(['success' => 'resaux mise à jour  ']);
    }

    public function destroy(Request $request)
    {
        $network = Network::findOrFail((int) $request->input('deleteligneid'));
        $network->delete();
        return redirect()->route('resaux.index')->with(['success' => 'resaux supprimé ']);
    }
}
