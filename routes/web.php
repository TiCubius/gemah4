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

use Barryvdh\DomPDF\PDF;

Route::get('/', 'GemahController@index')->name('web.index');

Route::group(["prefix" => "/scolarites", "as" => "web.scolarites."], function () {
	Route::resource("/", "Scolarite\ScolariteController")->only("index");

	// En anglais, le singulier de '...ves' is 'fe'
	// Exemple: multiples lives -> one life
	// Par conséquent, le paramètre par défaut était elefe (Laravel 5.7)
	Route::resource("eleves", "Scolarite\EleveController")->parameters([
		'eleves' => 'eleve'
	]);

	Route::group(["prefix" => "/eleves/{eleve}", "as" => "eleves."], function () {
		Route::resource("tickets", "Scolarite\TicketController");
		Route::resource("documents", "Scolarite\DocumentController");

		Route::group(["prefix" => "/impressions", "as" => "impressions."], function () {
			Route::get("autorisations", "Scolarite\ImpressionController@autorisations")->name("autorisations");
			Route::get("consignes", "Scolarite\ImpressionController@consignes")->name("consignes");
			Route::get("conventions", "Scolarite\ImpressionController@conventions")->name("conventions");
			Route::get("recapitulatifs", "Scolarite\ImpressionController@recapitulatifs")->name("recapitulatifs");
			Route::get("recuperations", "Scolarite\ImpressionController@recuperations")->name("recuperations");
		});

        Route::group(["prefix" => "/documents", "as" => "documents."], function () {
            Route::resource("decisions", "Scolarite\DecisionController");
            Route::get("/decisions/{decision}/download", "Scolarite\DecisionController@download")->name("decisions.download");
            Route::get("/{document}/download", "Scolarite\DocumentController@download")->name("download");
        });

		// Liste du matériel de l'élève
		Route::get("/materiels", "Scolarite\EleveController@materiels")->name("materiels");

		Route::group(["prefix" => "tickets/{ticket}", "as" => "tickets."], function () {
			Route::resource("messages", "Scolarite\TicketMessageController")->only(["store", "edit", "update", "destroy"]);
		});
	});

	Route::resource("enseignants", "Scolarite\EnseignantController");
	Route::resource("etablissements", "Scolarite\EtablissementController");

	Route::group(["prefix" => "eleves/{eleve}/affectations", "as" => "eleves.affectations."], function () {
		//Affectation d'un établissement
		Route::group(["prefix" => "etablissements", "as" => "etablissements."], function () {
			Route::get("/", "Scolarite\Affectations\EtablissementController@index")->name("index");
			Route::post("/{etablissement}", "Scolarite\Affectations\EtablissementController@attach")->name("attach");
			Route::delete("/{etablissement}", "Scolarite\Affectations\EtablissementController@detach")->name("detach");
		});

		//Affectation d'un matériel
		Route::group(["prefix" => "materiels", "as" => "materiels."], function () {
			Route::get("/", "Scolarite\Affectations\MaterielController@index")->name("index");
			Route::post("/{materiel}", "Scolarite\Affectations\MaterielController@attach")->name("attach");
			Route::delete("/{materiel}", "Scolarite\Affectations\MaterielController@detach")->name("detach");
		});

		// Affectation d'un responsable
		Route::group(["prefix" => "responsables", "as" => "responsables."], function () {
			Route::get("/", "Scolarite\Affectations\ResponsableController@index")->name("index");
			Route::post("{responsable}", "Scolarite\Affectations\ResponsableController@attach")->name("attach");
			Route::delete("{responsable}", "Scolarite\Affectations\ResponsableController@detach")->name("detach");
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

Route::group(["prefix" => "/administrations", "as" => "web.administrations."], function () {
	Route::resource("/", "Administrations\AdministrationController")->only("index");

	Route::resource("departements", "Administrations\DepartementController");
	Route::resource("academies", "Administrations\AcademieController");
	Route::resource("regions", "Administrations\RegionController");

	Route::resource("services", "Administrations\ServiceController");
	Route::resource("utilisateurs", "Administrations\UtilisateurController");

    Route::group(["prefix" => "/eleves", "as" => "eleves."], function () {
        Route::resource("types", "Administrations\TypeEleveController");
    });

	Route::group(["prefix" => "/materiels", "as" => "materiels."], function () {
		Route::resource("etats", "Administrations\Materiels\EtatController");
	});
});
