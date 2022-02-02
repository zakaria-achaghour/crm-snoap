<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UgRepository
 
{


    public function ugsByUser($id){
        return  DB::table('ugs')
                    ->join('ug_user', 'ug_user.ug_id',  'ugs.id')
                    ->select('ugs.designation', 'ugs.id')->distinct()
                    ->where('ug_user.user_id', $id)
                    ->groupBy('ugs.designation', 'ugs.id')
                    ->get();
    }
    public function ugsByUserRegion($id,$regions){
     
        return  DB::table('ugs')
                    ->join('ug_user', 'ug_user.ug_id',  'ugs.id')
                    ->select('ugs.designation', 'ugs.id')->distinct()
                    ->where('ug_user.user_id', $id)
                    ->whereIn('regionmc_id',$regions)
                    ->groupBy('ugs.designation', 'ugs.id')
                    ->get();
    }

    public function numUgByUg($id){
        $numugs = DB::table('ugs')
        ->join('ug_numug', 'ug_numug.ug_id',  'ugs.id')
        ->select('ug_numug.num_ug')
        ->whereIn('ugs.id', $id)
        ->groupBy('ug_numug.num_ug')
        ->get();

        $nums = [];
        foreach($numugs as $num){
            array_push($nums,$num->num_ug);
        }
        return $nums;
    }
}
