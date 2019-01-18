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

Route::group(["prefix" => "/scolarites", "as" => "web.scolarites."], function () {
	Route::resource("/", "Scolarites\ScolariteController")->only("index");

	// En anglais, le singulier de '...ves' is 'fe'
	// Exemple: multiples lives -> one life
	// Par conséquent, le paramètre par défaut était elefe (Laravel 5.7)
	Route::resource("eleves", "Scolarites\EleveController")->parameters([
		'eleves' => 'eleve',
	]);

	Route::group(["prefix" => "/eleves/{eleve}", "as" => "eleves."], function () {
		Route::resource("tickets", "Scolarites\TicketController");
		Route::resource("documents", "Scolarites\Documents\DocumentController");

		Route::group(["prefix" => "/impressions", "as" => "impressions."], function () {
			Route::get("autorisations", "Scolarites\Documents\ImpressionController@autorisations")->name("autorisations");
			Route::get("consignes", "Scolarites\Documents\ImpressionController@consignes")->name("consignes");
			Route::get("conventions", "Scolarites\Documents\ImpressionController@conventions")->name("conventions");
			Route::get("recapitulatifs", "Scolarites\Documents\ImpressionController@recapitulatifs")->name("recapitulatifs");
			Route::get("recuperations", "Scolarites\Documents\ImpressionController@recuperations")->name("recuperations");
		});

		Route::group(["prefix" => "/documents", "as" => "documents."], function () {
			Route::resource("decisions", "Scolarites\Documents\DecisionController");
			Route::get("/decisions/{decision}/download", "Scolarites\Documents\DecisionController@download")->name("decisions.download");
			Route::get("/{document}/download", "Scolarites\Documents\DocumentController@download")->name("download");
		});

		// Liste du matériel de l'élève
		Route::get("/materiels", "Scolarites\EleveController@materiels")->name("materiels");

		Route::group(["prefix" => "tickets/{ticket}", "as" => "tickets."], function () {
			Route::resource("messages", "Scolarites\TicketMessageController")->only(["store", "edit", "update", "destroy"]);
		});
	});

	Route::resource("enseignants", "Scolarites\EnseignantController");
	Route::resource("etablissements", "Scolarites\EtablissementController");

	Route::group([
		"prefix" => "eleves/{eleve}/affectations",
		"as"     => "eleves.affectations.",
	], function () {
		//Affectation d'un établissement
		Route::group([
			"prefix" => "etablissements",
			"as"     => "etablissements.",
		], function () {
			Route::get("/", "Scolarites\Affectations\EtablissementController@index")->name("index");
			Route::post("/{etablissement}", "Scolarites\Affectations\EtablissementController@attach")->name("attach");
			Route::delete("/{etablissement}", "Scolarites\Affectations\EtablissementController@detach")->name("detach");
		});

		//Affectation d'un matériel
		Route::group(["prefix" => "materiels", "as" => "materiels."], function () {
			Route::get("/", "Scolarites\Affectations\MaterielController@index")->name("index");
			Route::post("/{materiel}", "Scolarites\Affectations\MaterielController@attach")->name("attach");
			Route::delete("/{materiel}", "Scolarites\Affectations\MaterielController@detach")->name("detach");
		});

		// Affectation d'un responsable
		Route::group(["prefix" => "responsables", "as" => "responsables."], function () {
			Route::get("/", "Scolarites\Affectations\ResponsableController@index")->name("index");
			Route::post("{responsable}", "Scolarites\Affectations\ResponsableController@attach")->name("attach");
			Route::delete("{responsable}", "Scolarites\Affectations\ResponsableController@detach")->name("detach");
		});
	});
});

Route::group(["prefix" => "/", "as" => "web."], function () {
	Route::resource("responsables", "Responsables\ResponsableController");
});

Route::group(["prefix" => "/materiels", "as" => "web.materiels."], function () {
	Route::resource("/", "Materiels\MaterielController")->only("index");

	Route::resource("domaines", "Materiels\DomaineMaterielController");
	Route::resource("types", "Materiels\TypeMaterielController");
	Route::resource("stocks", "Materiels\StockMaterielController");
});

Route::group([
	"prefix" => "/administrations",
	"as"     => "web.administrations.",
], function () {
	Route::resource("/", "Administrations\AdministrationController")->only("index");

	Route::resource("departements", "Administrations\DepartementController");
	Route::resource("academies", "Administrations\AcademieController");
	Route::resource("regions", "Administrations\RegionController");

	Route::resource("services", "Administrations\ServiceController");
	Route::resource("utilisateurs", "Administrations\UtilisateurController");

	Route::group(["prefix" => "/eleves", "as" => "eleves."], function () {
		Route::resource("types", "Administrations\Types\TypeEleveController");
	});

	Route::group(["prefix" => "/etablissements", "as" => "etablissements."], function () {
		Route::resource("types", "Administrations\Types\TypeEtablissementController");
	});

	Route::group(["prefix" => "/materiels", "as" => "materiels."], function () {
		Route::resource("etats", "Administrations\Materiels\EtatMaterielController");
	});

	Route::group(["prefix" => "/types", "as" => "types."], function () {
		Route::resource("tickets", "Administrations\Types\TypeTicketController");
	});
});

Route::group(["prefix" => "/conventions", "as" => "web.conventions."], function () {
	Route::get("/", "Responsables\ConventionController@index")->name("index");
	Route::patch("/", "Responsables\ConventionController@update")->name("update");
	Route::get("signatures_effectues", "Responsables\ConventionController@signatures_effectues")->name("signatures_effectues");
	Route::get("signatures_manquantes", "Responsables\ConventionController@signatures_manquantes")->name("signatures_manquantes");
});
