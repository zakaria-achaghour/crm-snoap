<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecouvrementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
   }


    public function index()
    {
        $cheques = DB::table('cheques')
             ->join('clients', 'clients.id', '=', 'cheques.client_id')
             ->join('villes', 'villes.id', '=', 'clients.ville_id')
             ->select('clients.nom','clients.sage','clients.adresse', 'villes.nom as ville','cheques.*')
             ->get();
          // dd($cheques);

        return view('admin.recouvrement.index', ['cheques' => $cheques]);
    }

    public function create()
    {


        return view('admin.recouvrement.create', ['clients' => Client::all()]);
    }

    public function store(Request $request)
    {

        $cheque = new Cheque();
        $cheque->date_recouvrement = $request->input('date_recouvrement');
        $cheque->montant = $request->input('montant');
        $cheque->paye = $request->input('paye');
        //$cheque->statu = $request->input('statu');
        $cheque->client_id = $request->input('client');
        $cheque->observation = $request->input('observation');
        $cheque->save();

        $rest =$request->input('montant')-$request->input('paye');
        $client = Client::find($request->input('client'));
        if($request->input('paye')!= $request->input('montant')){
            $client->bloque = 1;
            $client->motif = "recouvrement (le rest est :".$rest.")";
        }else{
            $client->bloque = 0;
            $client->motif = "";
        }
        
            $client->save();

        return redirect()->route('recouvrement.index');
    }

    public function edit($id){

        return  view('admin.recouvrement.edit', ['clients' => Client::all(), 'cheque' =>Cheque::find($id)]);
    }
    public function update(Request $request,$id){

        $cheque = Cheque::find($id);
        $cheque->date_recouvrement = $request->input('date_recouvrement');
        $cheque->montant = $request->input('montant');
        $cheque->paye = $request->input('paye');
        $cheque->observation = $request->input('observation');
        //$cheque->statu = $request->input('statu');
        $cheque->client_id = $request->input('client');
        $cheque->save();
        
        $rest =$request->input('montant')-$request->input('paye');
        $client = Client::find($request->input('client'));
        if($request->input('paye')!= $request->input('montant')){
            $client->bloque = 1;
            $client->motif = "recouvrement (le rest est :".$rest.")";
        }else{
            $client->bloque = 0;
            $client->motif = "";
        }
        $client->save();
        return redirect()->route('recouvrement.index');
  
    }
}
