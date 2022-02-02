<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


require __DIR__.'/auth.php';
Route::get('/','AdminController@dash')->middleware(['auth'])->name('dashboard');

// update profile
Route::match(['get','put'],'/edit-profile','AdminController@profile_edit')->name('profile_edit');

// settings profile
Route::match(['get','put'],'/settings','AdminController@settings')->name('settings');

// check the user password
Route::post('/check-pwd','AdminController@checkPassword')->name('checkPassword');



// users + Familles + service + fournisseurs + articles + devis + unites + roles + distination + distinataire + natures

    Route::resource('/users','UserController')->except(['destroy','show']);
    Route::get('/users/{id}/restore', 'UserController@restore')->name('users.restore');
    Route::get('/users/{id}/delete','UserController@destroy')->name('users.destroy');
    Route::get('/users/{id}/reset','UserController@resetPassword')->name('users.reset');
    Route::resource('/roles','RoleController')->except(['destroy','show']);

    Route::resource('/villes','VilleController')->except('destroy');
    Route::post('/villes/delete','VilleController@destroy')->name('villes.destroy');

    Route::resource('/regions','RegionController')->except('destroy');
    Route::post('/regions/delete','RegionController@destroy')->name('regions.destroy');
  
    Route::resource('/grossistes','GrossisteController');

    Route::resource('/regionmcs','RegionMcController');
    Route::resource('/resaux','NetworkController');
    Route::resource('/products','ProductController');
    Route::resource('/ugs','UgController');
    Route::resource('/numugs','NumugController');

    Route::resource('/classes','ClasseController');
    Route::resource('/dcis','DciController');
    Route::resource('/plvs','PlvController');
    Route::resource('/fournisseurs','FournisseurController');
    Route::resource('/natures','NatureController');





    Route::get('/users/animateurs','UserController@animateurs')->name('users.animateurs');
    Route::get('/users/{animateur}/animateurs','UserController@animateurs')->name('users.editAnimateurs');

    Route::resource('/exercices','ExerciceController')->except(['destroy','show','delete']);
    Route::resource('/categories','CategoryController')->except(['destroy','show','delete']);

    Route::get('affecter','AffecterController@index')->name('affecter.index');
    Route::get('affecter/create','AffecterController@affecterRegionResauxUg')->name('affecter.create');
    Route::post('affecter','AffecterController@storeAffecter')->name('affecter.store');
    Route::delete('affecter/{id}','AffecterController@destroy')->name('affecter.destroy');


    Route::resource('/specialties','SpecialtyController')->except(['show']);
    Route::resource('/doctors','DoctorController')->except(['show']);



Route::resource('/clients','ClientController');
Route::get('/chequesencours','ClientController@chequesEnCours')->name('clients.chequesencours');
Route::get('/chequesencours/{client}/edit','ClientController@chequesEnCoursEdit')->name('clients.chequesencours.edit');
Route::put('/chequesencours/{client}/update','ClientController@chequesEnCoursUdpate')->name('clients.chequesencours.update');
Route::get('exporter_view/{var}/{ville}', 'ClientController@exporter_view')->name('exporter_view');

Route::resource('/recouvrement','RecouvrementController')->except('destroy');
// Route::get('/ca','VentController@index')->name('ca.index');
// Route::get('/ca/listAnnee','VentController@listAnnee')->name('ca.listAnnee');
// Route::get('/ca/annee/{annee}','VentController@annee')->name('ca.annee');

Route::prefix('statistique')->name('statistique.')->group(function () { 
   // Route::get('/userBloque','StatistiqueController@userBloque')->name('userBloque');
    Route::get('/bloque','StatistiqueController@bloque')->name('bloque');
    Route::get('/tout','StatistiqueController@tout')->name('tout');
    Route::get('/toutInfo','StatistiqueController@toutInfo')->name('toutInfo');

    Route::get('/listVille','StatistiqueController@listVille')->name('listVille');
    Route::get('/ville/{id}','StatistiqueController@ville')->name('ville');
    Route::get('/docManquant','StatistiqueController@docManque')->name('docManque');
    Route::get('/infoManquant','StatistiqueController@infoManquant')->name('infoManquant');
    Route::get('/userBloque','StatistiqueController@userBloque')->name('userBloque');
    Route::get('/recouvrement','StatistiqueController@annee')->name('recouvrement');
   
});

// vistes pharmacies 
Route::get('/visites/pharmacy/create/{client}/{planning}','VisiteController@create')->name('visites.create.pharmacy');
Route::get('/visites/pharmacy','VisiteController@index')->name('visites.index.pharmacy');
Route::post('/visites/pharmacy','VisiteController@store')->name('visites.store.pharmacy');


Route::get('/visites/pharmacy/DisplayDoctor/{visite_id}/{doctor_id}','VisiteController@DisplayDoctor')->name('visites.DisplayDoctor.pharmacy');
Route::get('visites/pharmacy/product/doctor/table/{id}', 'VisiteController@productDoctorTable')->name('visites.productDoctorTable.pharmacy');
Route::post('/visites/pharmacy/doctor','VisiteController@doctor')->name('visites.doctor.pharmacy');
Route::post('/visites/pharmacy/doctor/ordonance','VisiteController@doctorOrdonance')->name('visites.doctor.pharmacy.ordonance');

Route::get('visites/pharmacy/product/doctor/{id}', 'VisiteController@productDoctorDestroy')->name('visites.productDoctorDestroy.pharmacy');
Route::post('/visites/pharmacy/product','VisiteController@product')->name('visites.product.pharmacy');
Route::get('/visites/pharmacy/DisplayProduct/{visite_id}','VisiteController@DisplayProduct')->name('visites.DisplayProduct.pharmacy');
Route::get('visites/pharmacy/product/{id}', 'VisiteController@productDestroy')->name('visites.productDestroy.pharmacy');
Route::get('visites/pharmacy/product/table/{id}', 'VisiteController@productTable')->name('visites.productTable.pharmacy');

Route::get('visites/pharmacy/rupture/{visite}', 'VisiteController@rupture')->name('visites.rupture.pharmacy');
Route::post('/visites/pharmacy/rupture','VisiteController@storeRupture')->name('visites.product.rupture');
Route::get('visites/pharmacy/rupture/table/{id}', 'VisiteController@ruptureTable')->name('visites.ruptureTable.pharmacy');
Route::get('visites/pharmacy/rupture/destroy/{id}', 'VisiteController@ruptureDestroy')->name('visites.ruptureDestroy.pharmacy');



Route::get('visites/pharmacy/commande/{visite}', 'VisiteController@commande')->name('visites.commande.pharmacy');
Route::post('visites/pharmacy/commande','VisiteController@commandeVisite')->name('visites.commandeStore.pharmacy');

Route::get('visites/pharmacy/duo/{visite}','VisiteController@duo')->name('visites.duo.pharmacy');
Route::post('visites/pharmacy/duo','VisiteController@visiteduo')->name('visites.duostore.pharmacy');

Route::get('/visites/pharmacy/visiteUser/{id}','VisiteController@visiteUser')->name('visite.user.pharmacy');
Route::get('/visites/pharmacy/recherche/{de}/{a}/{user?}','VisiteController@recherche')->name('visite.recherche.pharmacy');
Route::get('/visites/pharmacy/edit/{visite_id}','VisiteController@edit')->name('visites.edit.pharmacy');


Route::get('visites/pharmacy/{visite}/plv/{client}','VisiteController@plv')->name('visites.plv.pharmacy');
Route::post('visites/pharmacy/plv','VisiteController@visiteplv')->name('visites.plvstore.pharmacy');
Route::get('visites/pharmacy/plv/{id}','VisiteController@deleteplv')->name('visites.deleteplv.pharmacy');
Route::get('visites/pharmacy/clientPlv/{client_id}','VisiteController@getClientPlv')->name('visites.getClientPlv.pharmacy');

Route::get('visites/pharmacy/emg/{visite}', 'VisiteController@emg')->name('visites.emg.pharmacy');
Route::post('visites/pharmacy/emg', 'VisiteController@emgStore')->name('visites.emgStore.pharmacy');
Route::get('visites/pharmacy/clientEmg/{visite}', 'VisiteController@clientEmg')->name('visites.clientEmg.pharmacy');
Route::get('visites/pharmacy/emg/destroy/{id}','VisiteController@deleteemg')->name('visites.deleteemg.pharmacy');

Route::get('/visites/pharmacy/fin/{id}','VisiteController@finVisite')->name('visites.fin.pharmacy');

// visites doctors 
Route::get('/visites/doctor','VisiteDoctorController@index')->name('visites.index.doctor');
Route::get('/visites/doctor/visiteUser/{id}','VisiteDoctorController@visiteUser')->name('visite.user.doctor');
Route::get('/visites/doctor/recherche/{de}/{a}/{user?}','VisiteDoctorController@recherche')->name('visite.recherche.doctor');

Route::get('/visites/doctor/create/{doctor}/{planning}','VisiteDoctorController@create')->name('visites.create.doctor');
Route::post('/visites/doctor','VisiteDoctorController@store')->name('visites.store.doctor');

Route::get('/visites/doctor/edit/{visite_id}','VisiteDoctorController@edit')->name('visites.edit.doctor');

Route::get('/visites/doctor/DisplayProduct/{visite_id}','VisiteDoctorController@DisplayProduct')->name('visites.DisplayProduct.doctor');
Route::post('/visites/doctor/product','VisiteDoctorController@product')->name('visites.product.doctor');
Route::get('visites/doctor/product/table/{id}', 'VisiteDoctorController@productTable')->name('visites.productTable.doctor');
Route::get('/visites/doctor/product/{id}', 'VisiteDoctorController@productDestroy')->name('visites.productDestroy.doctor');
Route::get('/visites/doctor/{visite}/duo','VisiteDoctorController@duo')->name('visites.duo.doctor');
Route::post('/visites/doctor/duo','VisiteDoctorController@visiteduo')->name('visites.duostore.doctor');

Route::get('/visites/doctor/{visite}/plv/{client}','VisiteDoctorController@plv')->name('visites.plv.doctor');
Route::post('/visites/doctor/plv','VisiteDoctorController@visiteplv')->name('visites.plvstore.doctor');
Route::get('/visites/doctor/plv/{id}','VisiteDoctorController@deleteplv')->name('visites.deleteplv.doctor');
Route::get('/visites/doctor/clientPlv/{client_id}','VisiteDoctorController@getClientPlv')->name('visites.getClientPlv.doctor');

Route::get('/visites/doctor/emg/{visite}', 'VisiteDoctorController@emg')->name('visites.emg.doctor');
Route::post('/visites/doctor/emg', 'VisiteDoctorController@emgStore')->name('visites.emgStore.doctor');
Route::get('/visites/doctor/clientEmg/{visite}', 'VisiteDoctorController@clientEmg')->name('visites.clientEmg.doctor');
Route::get('/visites/doctor/emg/destroy/{id}','VisiteDoctorController@deleteemg')->name('visites.deleteemg.doctor');
Route::get('/visites/doctor/demande/{visite_id}','VisiteDoctorController@demandeDoctor')->name('visites.demande.doctor');
Route::post('/visites/doctor/demande','VisiteDoctorController@demandeDoctorStore')->name('visites.demande.store');
Route::get('/visites/doctor/fin/{id}','VisiteDoctorController@finVisite')->name('visites.fin.doctor');



//plannings pharmacy
Route::get('/plannings/pharmacies','PlanningController@index')->name('plannings.index.pharmacies');
Route::get('/plannings/pharmacies/create','PlanningController@create')->name('plannings.create.pharmacies');

Route::get('/plannings/pharmacies/{id}/delete','PlanningController@destroy')->name('plannings.destroy.pharmacies');
Route::get('/plannings/pharmacies/{id}/{de}/{a}','PlanningController@pharmacies')->name('plannings.pharmacies');
Route::get('/plannings/pharmacies/add/{id}/{de}/{a}/{delegue}','PlanningController@store')->name('plannings.store.pharmacies');
Route::get('/plannings/pharmacies/recherche/{de}/{a}/{user}','PlanningController@recherche')->name('plannings.recherche.pharmacies');
Route::get('/plannings/error','PlanningController@error')->name('planningError');
Route::get('/plannings/pharmacies/planningUser/{id}','PlanningController@planningUser')->name('plannings.user.pharmacies');


// plannings doctors

Route::get('/plannings/doctors','PlanningDoctorController@index')->name('plannings.doctors');
Route::get('/plannings/doctors/create','PlanningDoctorController@create')->name('plannings.create.doctors');
Route::get('/plannings/doctors/{id}/{de}/{a}','PlanningDoctorController@doctors')->name('plannings.doctor');
Route::get('/plannings/doctors/store/{id}/{de}/{a}/{delegue}','PlanningDoctorController@store')->name('plannings.store.doctors');
Route::get('/plannings/doctors/recherche/{de}/{a}/{user}','PlanningDoctorController@recherche')->name('plannings.recherche.doctors');
Route::get('/plannings/doctors/planningUser/{id}','PlanningDoctorController@planningUser')->name('plannings.user.doctors');
Route::get('/plannings/doctors/{id}/delete','PlanningDoctorController@destroy')->name('plannings.destroy.doctors');


Route::get('/rapports','RapportController@index')->name('rapports.index');
Route::get('/rapports/visite/medecin','RapportController@visiteMedcine')->name('rapport.visite.mdecine');
Route::get('/rapports/visite/medecin/exporter/{de}/{a}/{region}/{ug}/{produit}/{delegue}','RapportController@exporterMedecinVisite')->name('rapport.visite.medecin.exporter');
Route::get('exporter/{de}/{a}/{region}/{ug}/{produit}/{delegue}', 'RapportController@exporter_view')->name('exporter');
Route::get('/rapports/visite/change/ug/{region}','RapportController@chnageUg')->name('rapport.visite.mdecine.change.ug');

Route::get('/rapports/visite/emg','RapportController@visiteEmg')->name('rapport.visite.emg');
Route::get('/rapports/visite/emg/{de}/{a}/{delegues}/{produit}','RapportController@exportervisiteEmg')->name('rapport.visite.emg.table');
Route::get('/rapports/visite/emg/exporter/{de}/{a}/{delegues}/{produit}','RapportController@exporter_view_emg')->name('rapport.visite.emg.exporter');

Route::get('/rapports/visite/duo','RapportController@visiteDuo')->name('rapport.visite.duo');
Route::get('/rapports/visite/duo/{de}/{a}/{delegues}','RapportController@exportervisiteDuo')->name('rapport.visite.duo.table');
Route::get('/rapports/visite/duo/exporter/{de}/{a}/{delegues}','RapportController@exporter_view_emg')->name('rapport.visite.duo.exporter');

Route::get('/rapports/visite/plv','RapportController@visitePlv')->name('rapport.visite.plv');
Route::get('/rapports/visite/plv/{de}/{a}/{delegues}/{produit}','RapportController@exportervisitePlv')->name('rapport.visite.plv.table');
Route::get('/rapports/visite/plv/exporter/{de}/{a}/{delegues}/{produit}','RapportController@exporter_view_plv')->name('rapport.visite.plv.exporter');


Route::get('/rapports/visite/fiche','RapportController@visiteFiche')->name('rapport.visite.fiche');
Route::get('/rapports/visite/fiche/{de}/{a}/{delegues}/{produit}','RapportController@exportervisiteFiche')->name('rapport.visite.fiche.table');
Route::get('/rapports/visite/fiche/exporter/{de}/{a}/{delegues}/{produit}','RapportController@exporter_view_fiche')->name('rapport.visite.fiche.exporter');

Route::get('/rapports/visite/nombres','RapportController@visiteNombres')->name('rapport.visite.nombres');
Route::get('/rapports/visite/nombres/{de}/{a}/{delegues}','RapportController@exportervisiteNombres')->name('rapport.visite.nombres.table');
Route::get('/rapports/visite/nombres/exporter/{de}/{a}/{delegues}','RapportController@exporter_view_nombres')->name('rapport.visite.nombres.exporter');

Route::get('/rapports/visite/nombres/regions/{de}/{a}/{regions}','RapportController@exportervisiteNombresRegions')->name('rapport.visite.nombres.regions.table');
Route::get('/rapports/visite/nombres/regions/exporter/{de}/{a}/{regions}','RapportController@exporter_view_Regions')->name('rapport.visite.nombres.regions.exporter');


Route::get('/rapports/visite/pharmacies','RapportController@visitePharmacies')->name('rapport.visite.pharmacies');
Route::get('/rapports/visite/pharmacies/exporter/{de}/{a}/{region}/{ug}/{produit}/{delegue}','RapportController@exporterPharmaciesVisite')->name('rapport.visite.pharmacies.exporter');
Route::get('exporter/pharmacies/{de}/{a}/{region}/{ug}/{produit}/{delegue}', 'RapportController@exporter_view_pharmacies')->name('exporter.pharmacies');
Route::get('/rapports/change/chartByDate/{de}/{a}','RapportController@changeChartByDate')->name('rapport.change.chart.by.date');
Route::get('/rapports/change/chartByDatePie/{de}/{a}','RapportController@changeChartByDatePie')->name('rapport.change.chart.by.date.pie');

Route::get('/rapports/visite/demandes','RapportController@visiteDemandes')->name('rapport.visite.demandes');
Route::get('/rapports/visite/demandes/{de}/{a}/{delegues}','RapportController@exportVisiteDemandes')->name('rapport.visite.demandes.table');

Route::get('/rapports/visite/parcours','RapportController@visiteParcours')->name('rapport.visite.parcours');
Route::get('/rapports/visite/parcours/{de}/{a}/{delegues}','RapportController@exportVisiteParcours')->name('rapport.visite.parcours.table');

Route::get('/rapports/visite/rupture','RapportController@visiteRupture')->name('rapport.visite.rupture');
Route::get('/rapports/visite/rupture/{de}/{a}/{ugs}/{produits}','RapportController@exportVisiteRupture')->name('rapport.visite.rupture.table');
Route::get('exporter/ruptures/{de}/{a}/{ugs}/{produits}', 'RapportController@exporter_view_visite_rupture')->name('exporter.rupture');

Route::get('/rapports/visite/autre','RapportController@visiteAutre')->name('rapport.visite.autre');
Route::get('/rapports/visite/autre/{de}/{a}/{ugs}/{specialties}','RapportController@exportVisiteAutre')->name('rapport.visite.autre.table');

Route::get('/getUg/{user_id}','ObjectifController@getUg')->name('getUgByUser');



Route::resource('/objectifs','ObjectifController');
Route::get('/objectifs/product/{objectif_id}','ObjectifController@product')->name('objectifs.product');
Route::post('/objectifs/product/affecter','ObjectifController@affecterNombreBoite')->name('objectifs.affecter.product');
Route::get('/objectifs/product/table/{id}','ObjectifController@productObjectifTab')->name('objectifs.product.table');
Route::get('/objectifs/product/table/destroy/{id}/{objectif_id}','ObjectifController@productObjectifDestroy')->name('objectifs.product.destroy');

Route::resource('/limites','LimiteController');

Route::resource('advs', 'AdvController')->except('create');
Route::post('/advs/affecter/products','AdvController@affecterProductsAdv')->name('advs.affecterProductsAdv');
Route::get('/advs/table/products/{id}','AdvController@productTable')->name('advs.ProductTable');
Route::get('/advs/product/{id}','AdvController@deleteProduct')->name('advs.deleteProduct');
Route::get('/advs/products/forms/{id}','AdvController@productForm')->name('advs.productForm');
Route::get('/advs/fin/{id}','AdvController@fin')->name('advs.fin');

Route::get('/advs/status/{step}/{adv}','AdvController@changeStatus')->name('advs.change.status');
Route::get('/advs/commande/{adv}','AdvController@commande')->name('advs.commande');
Route::post('/advs/commande/store','AdvController@commandeStore')->name('advs.commande.store');

Route::get('/adv/create','AdvController@create')->name('advs.create');
Route::get('/adv/encours','AdvController@encours')->name('advs.encours');
Route::get('/adv/cree','AdvController@cree')->name('advs.cree');
Route::get('/adv/accepte','AdvController@accepte')->name('advs.accepte')->middleware(['can:admin.Manager']);
Route::get('/adv/valider','AdvController@valider')->name('advs.valider')->middleware(['can:admin.Manager+']);



Route::get('/adv/commander','AdvController@pourCommande')->name('advs.pour.commande');
Route::get('/adv/livrer','AdvController@pourLivrer')->name('advs.pour.livrer');
Route::get('/advs/livrer/{adv}','AdvController@livrer')->name('advs.livrer');
Route::post('/advs/livrer/store','AdvController@livrerStore')->name('advs.livrer.store');

Route::get('/adv/historique','AdvController@historique')->name('advs.historique');
Route::get('/adv/print/{adv}','AdvController@print')->name('advs.print');



// helpers 
Route::get('/change/multiselect','VisiteController@changeMultiSelect')->name('change.multiSelect');
Route::get('/change/multiselect/G','VisiteController@changeMultiSelectG')->name('change.multiSelectG');
 Route::get('/change/select/{id}','PlanningController@changeUgSelect')->name('change.select');


Route::get('/getUgByRegionmc/{regionmc_id}','AdvController@getUgByRegionmc')->name('getUgByRegionmc');
Route::get('/getDoctorsByUg/{ug_id}','AdvController@getDoctorByUg')->name('getDoctorByUg');
Route::get('/getDoctorInfo/{doctor_id}','AdvController@getDoctorInfo')->name('getDoctorInfo');

//users infos
Route::get('/getusersinfo','UserSystemInfoController@index')->name('getUsersInfo');


// javascripts lang routes 
Route::get('/client/lang/javascript/{item}',function($item){
    return trans('javascript.'.$item);
});


