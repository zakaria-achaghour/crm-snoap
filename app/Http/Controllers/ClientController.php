<?php

namespace App\Http\Controllers;

use App\Http\Requests\client\StoreClientRequest;
use App\Http\Requests\client\UpdateClientRequest;
use Illuminate\Http\Request;
use App\Models\Client;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientsExportView;
use App\Models\Plv;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
        $this->middleware('can:admin.administration.client.ecriture',['only'=>['store','create','update','exporter_view','destroy','chequesEnCoursEdit','chequesEnCoursUdpate']]);
    }

    //lister les notes
    public function index()
    {
        //$clients =Client::with('ville')->get();

        $clients = DB::table('clients')
        ->join('villes', 'villes.id', '=', 'clients.ville_id')
        ->select('clients.id','clients.nom','clients.autorisation','clients.adresse','clients.ugmc','clients.is','clients.pharmacien','clients.fichier','clients.sage','clients.bloque', 'villes.nom as ville' )
        ->orderByDesc('clients.id')
        ->get();

        return view('userSide.clients.index', ['clients' => $clients]);
    }

    //affiche le formulaire de creations des notes
    public function create()
    {
        $villes = DB::table('villes')->where('deleted_at',null)->orderBy('nom')->get();
       // $villes = Ville::all()->sortBy('nom');
        return view('userSide.clients.create', ['villes' => $villes,'plvs'=>Plv::all()]);
    }

    //Enregistrer les notes dans la base de donnee
    public function store(StoreClientRequest $request)
    {

    //    dd($request);
        $client = new Client();
        $client->nom = $request->input('nom');
        $client->intitulé = $request->input('intitulé');
        $client->ville_id = $request->input('ville');
        $client->ugmc = $request->input('numug');

        $client->type = (int)$request->input('type');
        $client->patente = $request->input('patente');
        $client->ice = $request->input('ice');
        $client->i_f = $request->input('i_f');
        $client->autorisation = $request->input('autorisation');
        $client->rc = $request->input('rc');
        $client->adresse = $request->input('adresse');
        $client->pharmacien = $request->input('pharmacien');
        $client->contact = $request->input('contact');
        $client->cin = $request->input('cin');

        $client->fichier_cin = (int)$request->input('f_cin');
        $client->fichier_diplome = (int)$request->input('f_diplome');
        $client->fichier_autorisation = (int)$request->input('f_autorisation');
        $client->fichier_rc_patente = (int)$request->input('f_rc_patente');
        $client->fichier_if_ice = (int)$request->input('f_if_ice');


        $client->statut =  (int)$request->input('statut');
        $client->is =(int)$request->input('is');
        $client->bloque = (int)$request->input('bloquer');
        $client->motif = $request->input('motif');
        $client->sage = $request->input('sage');

        $client->user_id = Auth::id();
        $client->updated_by = Auth::id();
        $client->save();

        // Upload Picture for current Post
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $file = $file->storeAs('Documents', $client->pharmacien . '.' . $file->guessClientExtension());
            $client->fichier = $file;
        }

        $client->save();

        if(Auth::user()->locale == "fr"){
            return redirect()->route('clients.index')->with(['success' => 'Nouveau client créé avec succès']);
        }else{
            return redirect()->route('clients.index')->with(['success' => 'New client created successfully']);
        }
        
    }


    //permet de recuperer un client et le met dans le formulaire
    public function edit($id)
    {
        //dd(Plv::all());
        $villes = DB::table('villes')->where('deleted_at',null)->orderBy('nom')->get();

        $client = Client::find($id);
        return view('userSide.clients.edit', ['client' => $client, 'villes' => $villes,'plvs'=>Plv::all()]);
    }

    //permet de modifier un client
    public function update(UpdateClientRequest $request, Client $client)
    {

        $client->nom = $request->input('nom');
        $client->intitulé = $request->input('intitulé');
        $client->ville_id = $request->input('ville');
        $client->ugmc = $request->input('numug');
        $client->type = (int)$request->input('type');
        $client->patente = $request->input('patente');
        $client->ice = $request->input('ice');
        $client->i_f = $request->input('i_f');
        $client->autorisation = $request->input('autorisation');
        $client->rc = $request->input('rc');
        $client->adresse = $request->input('adresse');
        $client->pharmacien = $request->input('pharmacien');
        $client->contact = $request->input('contact');
        $client->cin = $request->input('cin');

        $client->fichier_cin = (int)$request->input('f_cin');
        $client->fichier_diplome = (int)$request->input('f_diplome');
        $client->fichier_autorisation = (int)$request->input('f_autorisation');
        $client->fichier_rc_patente = (int)$request->input('f_rc_patente');
        $client->fichier_if_ice = (int)$request->input('f_if_ice');


        $client->statut =  (int)$request->input('statut');
        $client->bloque = (int)$request->input('bloquer');
        $client->motif = $request->input('motif');
       
        $client->sage = $request->input('sage');
        $client->is =(int)$request->input('is');

        $client->updated_by = Auth::id();
        // Upload Picture for current Post
        if ($request->hasFile('fichier')) {
            $file =  $request->file('fichier')
                ->store('Documents');

            $path = Storage::url($file);

            if ($client->fichier) {

                Storage::delete($client->fichier);
                $client->fichier = $path;
            } else {
                $client->fichier = $path;
            }
        }

        $client->save();

        $date = Carbon::now();
        
        $filtedData = [];
        foreach ($client->plvs as $plvOld) {
            if ($plvOld->pivot->finished_at == Null) {

                array_push($filtedData, $plvOld->id);
            }
        }

        
        $requestIds = $request->plvs;

       // dd($request->plvs);
         if($requestIds == NULL){

            $requestIds = [];
         }
        // dd($requestIds);
            for ($i = 0; $i < count($filtedData); $i++) {
                if (in_array($filtedData[$i], $requestIds)) {
                    $key = array_search($filtedData[$i],  $requestIds);
                    unset($requestIds[$key]);
                } else {
                    $client->plvs()->updateExistingPivot($plvOld->id, [
                        'finished_at' => $date,
                    ]);
                }
            }
        $client->plvs()->attach($requestIds);

         

       

        if(Auth::user()->locale == "fr"){
            return redirect()->route('clients.index')->with(['success' => 'Client mis à jour avec succès']);
        }else{
            return redirect()->route('clients.index')->with(['success' => 'Client updated successfully']);
        }
    }

    //permet de supprimer un client
    public function destroy($id)
    {
    }

    public function exporter_view($var,$ville)
    {
        
         return Excel::download(new ClientsExportView($var,$ville),'clients.xlsx');
    }


    public function chequesEnCours(){

       // $clients = Client::with('ville')->get();
        //   $clients  = DB::table('usermetas')
        // ->select('browser', DB::raw('count(*) as total'))
        // ->groupBy('browser')
        // ->get();
       //dd($clients);
       $clients = DB::table('clients')
                      ->join('villes','villes.id','clients.ville_id')
                      ->select('clients.*','villes.nom as ville')
                      ->get();
                     


        return view('userSide.chequesEnCours.index',['clients'=>$clients]);

    }

    public function chequesEnCoursEdit(Client $client){


       return view('userSide.chequesEnCours.edit',['client'=>$client]);
    }

    public function chequesEnCoursUdpate(Request $request,Client $client){

        $validated = $request->validate([
            'nombreCheque' => 'required',
        ]);
        
        $motif = '';
        if( $request->input('nombreCheque')>0){
            $motif = 'Cheque en Cours : '.$request->input('nombreCheque');

            $client->bloque=1;
        }else{
            $client->bloque=0;

        }

        $client->nombreCheque = $request->input('nombreCheque');
        $client->motif =$motif;

        $client->save();
       return  redirect()->route('clients.chequesencours');
    }
   
}
