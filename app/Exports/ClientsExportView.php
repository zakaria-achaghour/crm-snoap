<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Client;
class ClientsExportView implements FromView, ShouldAutoSize
{

    public $var;
    public $ville;
    public function __construct($var , $ville = null)
    {

        $this->ville = $ville;
        $this->var = $var;
    }

    public function view(): View
    {

        if($this->var == 'recouvrement'){
            $cheques = DB::table('cheques')
             ->join('clients', 'clients.id', '=', 'cheques.client_id')
             ->join('villes', 'villes.id', '=', 'clients.ville_id')
             ->select('clients.nom','clients.sage','clients.adresse', 'villes.nom as ville','cheques.*')
             ->get();
            return view('admin.recouvrement.table', ['cheques'=>$cheques])->with('message', 'Fichier Execl Downloaded avec success');

        }
        if($this->var == 'toutInfo'){
            $clients = DB::table('clients')
            ->join('villes', 'villes.id', '=', 'clients.ville_id')
            ->select('clients.*', 'villes.nom as ville')
            ->get();
            return view('statistiques.toutInfoAll', ['clients'=>$clients])->with('message', 'Fichier Execl Downloaded avec success');

        }

        if($this->var == 'tout'){
            $clients = DB::table('clients')
            ->join('villes', 'villes.id', '=', 'clients.ville_id')
            ->select('clients.*', 'villes.nom as ville')
            ->get();
            return view('clients.table', ['clients'=>$clients])->with('message', 'Fichier Execl Downloaded avec success');

        }
        if ($this->var == 'bloque') {
           // $clients = Client::where('bloque', 1)->get();
           $clients = DB::table('clients')
                            ->join('villes','villes.id','clients.ville_id')
                            ->select('clients.*','villes.nom as ville')
                            ->where('bloque', 1)
                            ->orwhere('nombreCheque','>',0)
                            ->get();
            return view('statistiques.tableBloque', ['clients'=>$clients])->with('message', 'Fichier Execl Downloaded avec success');
            
        }

        if ($this->var == 'docManque') {
            $clients = DB::table('clients')
            ->join('villes', 'villes.id', '=', 'clients.ville_id')
            ->select('clients.*', 'villes.nom as ville')
            ->whereNull('fichier')
            ->orWhere(function ($query) {
                $query->where('fichier_cin', false)
                    ->orWhere('fichier_diplome', false)
                    ->orWhere('fichier_autorisation', false)
                    ->orWhere('fichier_rc_patente', false)
                    ->orWhere('fichier_if_ice', false);
            })
            ->where('bloque', false)
            ->get();
            return view('statistiques.tableDocManquant', ['clients'=>$clients])->with('message', 'Fichier Execl Downloaded avec success');
            
        }

        if ($this->var == 'infoManque') {
           
        $clients = DB::table('clients')
        ->join('villes', 'villes.id', '=', 'clients.ville_id')
        ->select('clients.*', 'villes.nom as ville')
        ->orWhere(function ($query) {
            $query->where('patente', null)
                ->orWhere('ice', null)
                ->orWhere('i_f', null)
                ->orWhere('autorisation', null)
                ->orWhere('rc', null)
                ->orWhere('adresse', null)
                ->orWhere('pharmacien', null)
                ->orWhere('contact', null)
                ->orWhere('cin', null)
                ->orWhere('sage', null);
        })
        ->where('bloque', false)
        ->get();
            return view('statistiques.tableInfoManquant', ['clients'=>$clients])->with('message', 'Fichier Execl téléchargé avec succès ');
            
        }


        if ($this->var == 'ville') {
           
            $clients =  Client::where('ville_id',$this->ville)->get();
                return view('statistiques.tableVilles', ['clients'=>$clients])->with('message', 'Fichier Execl téléchargé avec succès ');
                
            }
    }
}
