<?php


namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepository
 
{

    public function productIdsByVisitePharmacyDoctor($visite){
        $productIDS = [];
        $visite_product_id = DB::table('visite_product_doctor')->join('products', 'products.id', 'visite_product_doctor.product_id')
            ->select('products.id')
            ->where('visite_product_doctor.visite_id', $visite)
            ->get();
        for ($i = 0; $i < count($visite_product_id); $i++) {
            array_push($productIDS, $visite_product_id[$i]->id);
        }
    
    return $productIDS;
    
    }

 public function productsByNetworksPharmacyDoctors($networks,$doctor,$productIDS){

        $products = DB::table('products')
        ->join('network_product','network_product.product_id','products.id')
        ->select('products.id','products.designation', 
        DB::raw("( select top(1) qte from visite_doctor_product, visite_doctors 
        where visite_doctor_product.visite_doctor_id=visite_doctors.id
        and fin=1 and visite_doctor_product.product_id=products.id and visite_doctors.doctor_id=".$doctor." 
        order by visite_doctor_product.created_at desc ) as qte"))
        ->whereNotIn('products.id', $productIDS)
        ->where('products.statut', true)

        ->whereIn('network_product.network_id',$networks)
        ->groupBy('products.id','products.designation')
        ->orderBy('products.designation')->get();
    return $products;
 }



 public function productIdsByVisitePharmacy($visite){
    $productIDS = [];
    $visite_product_id = DB::table('visite_product')->join('products', 'products.id', 'visite_product.product_id')
        ->select('products.id')
        ->where('visite_product.visite_id', $visite)
        ->get();
    for ($i = 0; $i < count($visite_product_id); $i++) {
        array_push($productIDS, $visite_product_id[$i]->id);
    }

    return $productIDS;
 }

 public function productsByNetworksClient($networks,$client,$productIDS){
     // still have works
    $products = DB::table('products')
    ->join('network_product','network_product.product_id','products.id')
    ->select('products.id','products.designation', 
                DB::raw("( select top(1) qte from visite_product, visites 
                where visite_product.visite_id=visites.id
                and fin=1 and visite_product.product_id=products.id and visites.client_id=".$client." 
                order by visite_product.created_at desc ) as qte")
                )
    ->whereNotIn('products.id', $productIDS)
    ->where('products.statut', true)
    ->whereIn('network_product.network_id',$networks)
    ->groupBy('products.id','products.designation')
    ->orderBy('products.designation')->get();


 }
 
 
public function productEmgIdsPharmacy($visite) {
    $emgIDs = [];
        $visite_emgs_id = DB::table('visite_emg')->join('products', 'products.id', 'visite_emg.product_id')
            ->select('products.id')
            ->where('visite_emg.visite_id', $visite)
            ->get();
        for ($i = 0; $i < count($visite_emgs_id); $i++) {
            array_push($emgIDs, $visite_emgs_id[$i]->id);
        }

        return $emgIDs;
}

// for visite doctor and pharmacy
public function productByNetwork($ids,$networks) {

    return Product::join('network_product','network_product.product_id','products.id')
                    ->select('products.id','products.designation' )
                    ->whereNotIn('products.id', $ids)
                    ->whereIn('network_product.network_id',$networks)
                    ->where('products.statut', true)
                      ->groupBy('products.id','products.designation')

                    ->get();


}

public function productRuptureIdsPharmacy($visite) {
    $productIDS = [];
        $visite_rupture_id = DB::table('ruptures')
            ->join('products', 'products.id', 'ruptures.product_id')
            ->select('products.id')
            ->where('ruptures.visite_id', $visite)
            ->get();
        for ($i = 0; $i < count($visite_rupture_id); $i++) {
            array_push($productIDS, $visite_rupture_id[$i]->id);
        }
        return $productIDS;
}

// fro visites DOctors
public function productIdsByVisiteDoctor($visite){
    $productIDS = [];
    $visite_product_id=DB::table('visite_doctor_product')->join('products', 'products.id', 'visite_doctor_product.product_id')
    ->select('products.id')
    ->where('visite_doctor_product.visite_doctor_id',$visite)
    ->get();
    for ($i=0; $i <count($visite_product_id) ; $i++) { 
        array_push($productIDS,$visite_product_id[$i]->id);
    }


    return $productIDS;
 }

 public function productVisiteDoctorWhenLastIdNull($Ids,$networks){
    // $products = DB::table('products')
    // ->select('products.id','products.designation', 
    // DB::raw("NULL as qte"),

    // DB::raw("NULL as created_at"))
    // ->whereNotIn('products.id', $Ids)
    // ->orderBy('products.designation')->get();
   return  Product::join('network_product','network_product.product_id','products.id')
                    ->select('products.id','products.designation' ,DB::raw("NULL as qte"),

                    DB::raw("NULL as created_at"))
                    ->whereNotIn('products.id', $Ids)
                    ->where('products.statut',true)
                    ->whereIn('network_product.network_id',$networks)
                      ->groupBy('products.id','products.designation')

                    ->get();

 }

 public function productVisiteDoctorWhenLastExist($Ids,$networks,$visiteIdLast,$doctor){
    return DB::table('products')
    ->join('network_product','network_product.product_id','products.id')
    ->select('products.id','products.designation', 
    DB::raw("( select top(1) qte from visite_doctor_product, visite_doctors 
    where visite_doctor_product.visite_doctor_id=visite_doctors.id and visite_doctor_product.product_id=products.id and visite_doctors.fin=1 and visite_doctors.doctor_id=".$doctor." 
    order by visite_doctor_product.created_at desc) as qte"),

    DB::raw("( select top(1)  visite_doctors.created_at from visite_doctors ,visite_doctor_product
    where visite_doctors.id=".$visiteIdLast." and visite_doctors.fin=1 and visite_doctor_product.visite_doctor_id=visite_doctors.id and visite_doctor_product.product_id=products.id
    order by  visite_doctors.created_at desc) as created_at"))

    ->whereNotIn('products.id',$Ids) 
    ->where('products.statut', true)
     ->whereIn('network_product.network_id',$networks)
    ->groupBy('products.id','products.designation')
    ->orderBy('products.designation')->get();
}

public function productEmgIdsDoctor($visite) {
    $emgIDs = [];
        $visite_emgs_id = DB::table('visite_doctor_emg')->join('products', 'products.id', 'visite_doctor_emg.product_id')
            ->select('products.id')
            ->where('visite_doctor_emg.visite_doctor_id', $visite)
            ->get();
        for ($i = 0; $i < count($visite_emgs_id); $i++) {
            array_push($emgIDs, $visite_emgs_id[$i]->id);
        }
        return $emgIDs;
}


public function productEmgvisiteDoctor($Ids,$networks,$visite,$doctor) {

    return DB::table('products')
    ->join('network_product','network_product.product_id','products.id')
        ->select('products.id','products.designation', 
       DB::raw("( select top(1) qte from visite_doctor_product, visite_doctors 
        where visite_doctor_product.visite_doctor_id=".$visite." and visite_doctor_product.product_id=products.id  and visite_doctors.doctor_id=".$doctor." 
       ) as qte"))
        ->whereNotIn('products.id', $Ids)
        ->where('products.statut', true)
        ->whereIn('network_product.network_id',$networks)
        ->groupBy('products.id','products.designation')
        ->orderBy('products.designation')->get();
}

// for rapport 

public function productsByNetworks($networks){
    return Product::join('network_product','network_product.product_id','products.id')
                    ->select('products.id','products.designation' )
                    ->whereIn('network_product.network_id',$networks)
                    ->where('products.statut', true)
                    ->groupBy('products.id','products.designation')
                    ->get();
}
public function productIdsByNetworks($networks){
    $products =  DB::table('products')
                    ->join('network_product','network_product.product_id','products.id')
                    ->select('products.id' )
                    ->whereIn('network_product.network_id',$networks)
                    ->where('products.statut', true)
                    ->groupBy('products.id')
                    ->whereNull('products.deleted_at')
                    ->get();

//dd($products);
         $Ids = [];
        for ($i = 0; $i < count($products); $i++) {
           // dd($products[$i]->id);
            array_push($Ids,$products[$i]->id);
        }
     // dd($Ids);
       
     return $Ids;
}

}