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

Route::group(["prefix" => "/scolarites", "as" => "web.scolarites."], function() {
	Route::resource("/", "Scolarite\ScolariteController")->only("index");

	Route::resource("enseignants", "Scolarite\EnseignantController");
});

Route::group(["prefix" => "/", "as" => "web."], function() {
	Route::resource("responsables", "Responsables\ResponsableController");
});

Route::group(["prefix" => "/materiels", "as" => "web.materiels."], function() {
	Route::resource("/", "Materiels\MaterielController")->only("index");

	Route::resource("domaines", "Materiels\DomaineMaterielController");
	Route::resource("types", "Materiels\TypeMaterielController");
	Route::resource("stocks", "Materiels\StockMaterielController");
});

Route::group(["prefix" => "/administrations", "as" => "web.administrations."], function() {
	Route::resource("/", "Administrations\AdministrationController")->only("index");

	Route::resource("academies", "Administrations\AcademieController");
	Route::resource("regions", "Administrations\RegionController");

	Route::resource("services", "Administrations\ServiceController");
	Route::resource("utilisateurs", "Administrations\UtilisateurController");

	Route::group(["prefix" => "/materiels", "as" => "materiels."], function() {
		Route::resource("etats", "Administrations\Materiels\EtatController");
	});
});