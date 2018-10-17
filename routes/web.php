<?php

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

Route::get('/', 'GemahController@index')->name('web.index');

Route::get("/administrations", "Administrations\AdministrationsController@index")->name("web.administrations.index");

Route::get("/administrations/academies", "Administrations\AcademiesController@index")->name("web.administrations.academies.index");
Route::get("/administrations/academies/new", "Administrations\AcademiesController@create")->name("web.administrations.academies.create");
Route::post("/administrations/academies", "Administrations\AcademiesController@store");
Route::get("/administrations/academies/{id}/edit", "Administrations\AcademiesController@edit")->name("web.administrations.academies.edit");
Route::put("/administrations/academies/{id}", "Administrations\AcademiesController@update")->name("web.administrations.academies.update");

Route::get("/administrations/regions", "Administrations\RegionsController@index")->name("web.administrations.regions.index");
Route::get("/administrations/regions/new", "Administrations\RegionsController@create")->name("web.administrations.regions.create");
Route::post("/administrations/regions", "Administrations\RegionsController@store");
Route::get("/administrations/regions/{id}/edit", "Administrations\RegionsController@edit")->name("web.administrations.regions.edit");
Route::put("/administrations/regions/{id}", "Administrations\RegionsController@update")->name("web.administrations.regions.update");

Route::get("/administrations/utilisateurs", "Administrations\UtilisateursController@index")->name("web.administrations.utilisateurs.index");
Route::get("/administrations/utilisateurs/new", "Administrations\UtilisateursController@create")->name("web.administrations.utilisateurs.create");
Route::post("/administrations/utilisateurs", "Administrations\UtilisateursController@store");
Route::get("/administrations/utilisateurs/{id}/edit", "Administrations\UtilisateursController@edit")->name("web.administrations.utilisateurs.edit");
Route::put("/administrations/utilisateurs/{id}", "Administrations\UtilisateursController@update")->name("web.administrations.utilisateurs.update");
Route::delete("/administrations/utilisateurs/{id}", "Administrations\UtilisateursController@destroy")->name("web.administrations.utilisateurs.destroy");

Route::get("/administrations/services", "Administrations\ServicesController@index")->name("web.administrations.services.index");
Route::get("/administrations/services/new", "Administrations\ServicesController@create")->name("web.administrations.services.create");
Route::post("/administrations/services", "Administrations\ServicesController@store");
Route::get("/administrations/services/{id}/edit", "Administrations\ServicesController@edit")->name("web.administrations.services.edit");
Route::put("/administrations/services/{id}", "Administrations\ServicesController@update")->name("web.administrations.services.update");
Route::delete("/administrations/services/{id}", "Administrations\ServicesController@destroy")->name("web.administrations.services.destroy");


Route::get("/administrations/materiels/etats", "Administrations\Materiels\EtatsController@index")->name("web.administrations.materiels.etats.index");
Route::get("/administrations/materiels/etats/new", "Administrations\Materiels\EtatsController@create")->name("web.administrations.materiels.etats.create");
Route::post("/administrations/materiels/etats", "Administrations\Materiels\EtatsController@store");
Route::get("/administrations/materiels/etats/{etat}/edit", "Administrations\Materiels\EtatsController@edit")->name("web.administrations.materiels.etats.edit");
Route::put("/administrations/materiels/etats/{etat}", "Administrations\Materiels\EtatsController@update")->name("web.administrations.materiels.etats.update");
Route::delete("/administrations/materiels/etats/{etat}", "Administrations\Materiels\EtatsController@destroy")->name("web.administrations.materiels.etats.destroy");


Route::get("/responsables", "Responsables\ResponsablesController@index")->name("web.responsables.index");
Route::get("/responsables/new", "Responsables\ResponsablesController@create")->name("web.responsables.create");
Route::post("/responsables", "Responsables\ResponsablesController@store");
Route::get("/responsables/{id}/edit", "Responsables\ResponsablesController@edit")->name("web.responsables.edit");
Route::put("/responsables/{id}", "Responsables\ResponsablesController@update")->name("web.responsables.update");
Route::delete("/responsables/{id}", "Responsables\ResponsablesController@destroy")->name("web.responsables.destroy");


Route::get("/materiels", "Materiels\MaterielsController@index")->name("web.materiels.index");

Route::get("/materiels/domaines/", "Materiels\DomainesMaterielController@index")->name("web.materiels.domaines.index");
Route::get("/materiels/domaines/new", "Materiels\DomainesMaterielController@create")->name("web.materiels.domaines.create");
Route::post("/materiels/domaines", "Materiels\DomainesMaterielController@store");
Route::get("/materiels/domaines/{id}/edit", "Materiels\DomainesMaterielController@edit")->name("web.materiels.domaines.edit");
Route::put("/materiels/domaines/{id}", "Materiels\DomainesMaterielController@update")->name("web.materiels.domaines.update");
Route::delete("/materiels/domaines/{id}", "Materiels\DomainesMaterielController@destroy")->name("web.materiels.domaines.destroy");

Route::get("/materiels/types/", "Materiels\TypesMaterielController@index")->name("web.materiels.types.index");
Route::get("/materiels/types/new", "Materiels\TypesMaterielController@create")->name("web.materiels.types.create");
Route::post("/materiels/types", "Materiels\TypesMaterielController@store");
Route::get("/materiels/types/{id}/edit", "Materiels\TypesMaterielController@edit")->name("web.materiels.types.edit");
Route::put("/materiels/types/{id}", "Materiels\TypesMaterielController@update")->name("web.materiels.types.update");
Route::delete("/materiels/types/{id}", "Materiels\TypesMaterielController@destroy")->name("web.materiels.types.destroy");

Route::get("/materiels/stocks/", "Materiels\StocksMaterielController@index")->name("web.materiels.stocks.index");
Route::get("/materiels/stocks/new", "Materiels\StocksMaterielController@create")->name("web.materiels.stocks.create");
Route::post("/materiels/stocks", "Materiels\StocksMaterielController@store");
Route::get("/materiels/stocks/{id}/edit", "Materiels\StocksMaterielController@edit")->name("web.materiels.stocks.edit");
Route::put("/materiels/stocks/{id}", "Materiels\StocksMaterielController@update")->name("web.materiels.stocks.update");
Route::delete("/materiels/stocks/{id}", "Materiels\StocksMaterielController@destroy")->name("web.materiels.stocks.destroy");