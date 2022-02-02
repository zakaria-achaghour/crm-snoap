<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NetworkRepository
 
{

    public function getNetworksIdsByUser($id){
            $networks = DB::table('user_regionmc_network')
            ->join('regionmc_networks','regionmc_networks.id','user_regionmc_network.regionmc_network_id')
            ->select('regionmc_networks.network_id')

            ->whereIn('user_regionmc_network.user_id',$id)

            ->groupBy('regionmc_networks.network_id')
            ->get();
            $netIds = [];
            foreach($networks as $net){
                array_push($netIds,$net->network_id);
            }

    return $netIds;
    }

}