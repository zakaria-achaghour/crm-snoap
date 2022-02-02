<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Ville;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
   }
    public function test(Request $request){
        dd($request);
    }

    public function test2(){
     return view('login');
    }
    public function index()
    {
        return view('statistiques.index');
    }


    
    public function bloque()
    {
      //  $clients = Client::where('bloque', 1)->orwhere('nombreCheque','>',0)->get();
        $clients = DB::table('clients')
        ->join('villes','villes.id','clients.ville_id')
        ->select('clients.*','villes.nom as ville')
        ->where('bloque', 1)
        ->where('is', true)
        ->orwhere('nombreCheque','>',0)
        ->get();
       
        //dd($clients);
        return view('statistiques.bloque', ['clients' => $clients]);
    }


    public function docManque()
    {
        $clients = DB::table('clients')
            ->join('villes', 'villes.id', '=', 'clients.ville_id')
            ->select('clients.*', 'villes.nom as ville')
            ->whereNull('fichier')
            ->orWhere(function ($query) {
                $query->where('fichier_cin', false)
                    ->orWhere('fichier_autorisation', false)
                    ->orWhere('fichier_if_ice', false);
            })
            ->where('bloque', false)
            ->where('is', true)
            ->get();

        return view('statistiques.docManquant', ['clients' => $clients]);
    }


    public function  listVille()
    {
        return view('statistiques.listVille', ['villes' => Ville::all()->sortBy('nom')]);
    }

    public function  ville($id)
    {
        
        
        return view('statistiques.ville', ['clients' => Client::where('ville_id',$id)->get(),'id'=>$id]);
    }

    public function tout()
    {
        $clients = DB::table('clients')
        ->join('villes', 'villes.id', '=', 'clients.ville_id')
        ->select('clients.id','clients.nom','clients.autorisation','clients.adresse','clients.pharmacien','clients.fichier','clients.sage','clients.bloque', 'villes.nom as ville' )
        ->where('is', true)
        ->get();
       // $clients = Client::with('ville')->get();
       
        
        return view('statistiques.tout', ['clients' => $clients]);
    }
    public function toutInfo()
    {
        $clients = DB::table('clients')
        ->join('villes', 'villes.id', '=', 'clients.ville_id')
        ->select('clients.*','villes.nom as ville' )
        ->where('is', true)
        ->get();
       // $clients = Client::with('ville')->get();
       
        
        return view('statistiques.toutInfo', ['clients' => $clients]);
    }

    public function infoManquant()
    {
        $clients = DB::table('clients')
            ->join('villes', 'villes.id', '=', 'clients.ville_id')
            ->select('clients.*', 'villes.nom as ville')
            ->where('bloque', false)
            ->where('is', true)
            ->Where(function ($query) {
                $query->Where('ice', null)
                    ->orWhere('i_f', null)
                    ->orWhere('autorisation', null)
                    ->orWhere('adresse', null)
                    ->orWhere('pharmacien', null)
                    ->orWhere('contact', null)
                    ->orWhere('cin', null)
                    ->orWhere('sage', null);
            })
            ->get();


        return view('statistiques.infoManquant', ['clients' => $clients]);
    }


   public function userBloque(){
       
       return view('statistiques.userBloque',['users' => User::onlyTrashed()->get()]);
   }
   public function annee()
   {
       
    $cheques = DB::table('cheques')
    ->select(DB::raw('count(id) as cheque'),DB::raw('sum(paye) as paye'),DB::raw('sum(montant) as montant'), DB::raw('datepart(yyyy, date_recouvrement) as annee'))
    ->groupBy(DB::raw('datepart(yyyy, date_recouvrement)'))
    ->orderBy('annee','DESC')
    ->get();
    

      //dd($cheques);

       $labels = [];
       $dataset = [];
       $dataset2 = [];
       $dataset3 = [];
       $total = 0;

       for ($i = 0; $i < count($cheques); $i++) {
           array_push($labels, $cheques[$i]->annee);
           array_push($dataset, $cheques[$i]->montant);
           array_push($dataset2, $cheques[$i]->paye);
           array_push($dataset3, $cheques[$i]->montant-$cheques[$i]->paye);
           $total += $dataset3[$i];
       }
       

       return view('statistiques.recouvrement',['labels'=>$labels,'data1'=>$dataset,'data2'=>$dataset2,'data3'=>$dataset3,'cheques'=>$cheques,'total'=>$total]);
   }
}
