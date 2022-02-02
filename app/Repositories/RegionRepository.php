<?php


namespace App\Repositories;
use Illuminate\Support\Facades\DB;

class RegionRepository
 
{

    public function getRegionsByUser($id){
            return  DB::table('user_regionmc_network')
            ->join('regionmc_networks','regionmc_networks.id','user_regionmc_network.regionmc_network_id')
            ->join('regionmcs','regionmcs.id','regionmc_networks.regionmc_id')
            ->select('regionmcs.id','regionmcs.designation')
            ->where('user_regionmc_network.user_id',$id)
            ->groupBy('regionmcs.id','regionmcs.designation')
            ->get();
          
    }

}