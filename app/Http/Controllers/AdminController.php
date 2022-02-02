<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Helpers\UserSystemInfoHelper;
use App\Models\UserSystemInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private $getip;
    private $getbrowser;
    private $getdevice;
    private $getos;

    public function __construct()
    {
        $this->middleware('auth');
        $this->getip = UserSystemInfoHelper::get_ip();
        $this->getbrowser = UserSystemInfoHelper::get_browsers();
        $this->getdevice = UserSystemInfoHelper::get_device();
        $this->getos = UserSystemInfoHelper::get_os();
    }

        

    // // login post 
    // public function test(Request $request)
    // {

    //     if (Auth::attempt(['username' => $request->input('login'), 'password' => $request->input('password')])) {
    //         Auth::user()->lastlogin = Carbon::now()->format(config('myconfig.date')); //add last login time
    //         Auth::user()->save(); //add last login time
    //         $userinfo = new UserSystemInfo();
    //         $userinfo->user_id =  Auth::id();
    //         $userinfo->ip_address =  $this->getip;
    //         $userinfo->browser =  $this->getbrowser;
    //         $userinfo->device =  $this->getdevice;
    //         $userinfo->os =  $this->getos;
    //         $userinfo->save();

    //         return redirect()->route('dash');
    //     } else {
    //         return redirect()->route('log')->with(['error' => "invalide Nom d'utilisateur ou mot de passe !!"]);
    //     }
    // }

    // // get form 
    // public function login()
    // {

    //     return view('login');
    // }



    // public function logout()
    // {

    //     Session::flush();

    //     Cache::forget('user-is-online-' . Auth::id());
    //     Auth::logout();

    //     return redirect()->route('log');
    // }

    public function dash()
    {

        $data['clients_docManque'] = count(DB::table('clients')
            ->whereNull('fichier')
            ->orWhere(function ($query) {
                $query->where('fichier_cin', false)
                    ->orWhere('fichier_diplome', false)
                    ->orWhere('fichier_autorisation', false)
                    ->orWhere('fichier_rc_patente', false)
                    ->orWhere('fichier_if_ice', false);
            })
            ->where('bloque', false)
            ->where('is', true)
            ->get());


        $data['clients_infoManque'] = count(DB::table('clients')

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
            ->where('is', true)
            ->get());

        $data['clients_bloque'] = count(Client::where('bloque', 1)->orwhere('nombreCheque', '>', 0)->where('is', true)->get());

        $data['users_bloque'] = count(User::onlyTrashed()->get());


        $data['clients_count'] = count(DB::table('clients')->where('is', true)->get());


        $regions = DB::table('regions')
            ->leftJoin('villes', 'villes.region_id', '=', 'regions.id')
            ->leftJoin('clients', 'clients.ville_id', '=', 'villes.id')
            ->select('regions.nom', DB::raw('count(clients.id) as total'))
            ->groupBy('regions.nom')
            ->orderby('total', 'DESC')
            ->get();
        $labels = [];
        $dataset = [];

        for ($i = 0; $i < count($regions); $i++) {
            array_push($labels, $regions[$i]->nom);
            array_push($dataset, $regions[$i]->total);
        }



        return view('dashboard', ['dataCount' => $data, 'labels' => $labels, 'data1' => $dataset]);
    }




    /****
     * 
     * Show Profile 
     * Edite Profile 
     * 
     */
    /**--------------------------------------------------------------------------
     * --------------------------------------------------------------------------
     */
    // method return view
    public function profile_edit(Request $request)
    {
        if ($request->isMethod('put')) {
            $request->validate([
                'firstname' => 'required|min:3',
                'lastname' => 'required|min:3',
                'email' => 'required|email',
                'username' => 'required|min:3',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|same:new_password'
            ]);

            $user = User::findOrFail(Auth::id());
            $data = $request->all();
            $user->password = Hash::make($data['new_password']);
            $user->save();
            return redirect()->route('profile_edit');
        }

        return view('edit_profile', ['user' => Auth::user()]);
    }







    /**=============================================================== */
    /**=============================================================== */
    // Account Settings
    /**=============================================================== */





    public function settings(Request $request)
    {

        if ($request->isMethod('put')) {

            $user = User::findOrFail(Auth::id());
            $user->locale = $request->input('locale');
            $user->save();

            return redirect()->route('settings');
        }

        return view('settings', ['user' => Auth::user()]);
    }
}
