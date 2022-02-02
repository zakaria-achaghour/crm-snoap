<?php

namespace App\Http\Controllers;

use App\Models\UserSystemInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSystemInfoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin.manage');
    }

    public function index()
    {
        $usersinfo = DB::table('users as u')
        ->join(DB::raw("(select user_id,MAX(created_at) as Maxcrt from user_system_infos 
        GROUP BY user_id )as pu"),'pu.user_id','=','u.id')
        ->join('user_system_infos as us', 'us.created_at', '=', 'pu.Maxcrt')
        ->select('us.user_id','u.gender','u.username','u.firstname','u.lastname','us.ip_address','us.browser','us.device',
        'us.os','us.created_at')
        ->orderByDesc('us.created_at')
        ->get();

        return view('admin.usersysteminfo.index',['usersinfo'=>$usersinfo]);
        // dd($usersinfo);


    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(UserSystemInfo $userSystemInfo)
    {
        //
    }

    public function edit(UserSystemInfo $userSystemInfo)
    {
        //
    }

    public function update(Request $request, UserSystemInfo $userSystemInfo)
    {
        //
    }


    public function destroy(UserSystemInfo $userSystemInfo)
    {
        //
    }
}
