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

Route::get("/administrations/utilisateurs", "Administrations\UtilisateursController@index")->name("web.administrations.utilisateurs.index");
Route::get("/administrations/utilisateurs/new", "Administrations\UtilisateursController@create")->name("web.administrations.utilisateurs.create");
Route::post("/administrations/utilisateurs", "Administrations\UtilisateursController@store");