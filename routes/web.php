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

Route::get("/administrations/services", "Administrations\ServicesController@index")->name("web.administrations.services.index");
Route::get("/administrations/services/new", "Administrations\ServicesController@create")->name("web.administrations.services.create");
Route::post("/administrations/services", "Administrations\ServicesController@store");
Route::get("/administrations/services/{id}/edit", "Administrations\ServicesController@edit")->name("web.administrations.services.edit");
Route::put("/administrations/services/{id}", "Administrations\ServicesController@update")->name("web.administrations.services.update");
