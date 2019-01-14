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
	Route::resource("/", "Scolarite\ScolariteController")->only("index");

	// En anglais, le singulier de '...ves' is 'fe'
	// Exemple: multiples lives -> one life
	// Par conséquent, le paramètre par défaut était elefe (Laravel 5.7)
	Route::resource("eleves", "Scolarite\EleveController")->parameters([
		'eleves' => 'eleve'
	]);

	Route::group(["prefix" => "/eleves/{eleve}", "as" => "eleves."], function () {
		Route::resource("tickets", "Scolarite\TicketController");

		// Liste du matériel de l'élève
		Route::get("/materiels", "Scolarite\EleveController@materiels")->name("materiels");

		Route::group(["prefix" => "tickets/{ticket}", "as" => "tickets."], function () {
			Route::resource("messages", "Scolarite\TicketMessageController")->only(["store", "edit", "update", "destroy"]);
		});
	});

	Route::resource("enseignants", "Scolarite\EnseignantController");
	Route::resource("etablissements", "Scolarite\EtablissementController");

    Route::group(["prefix" => "eleves/{eleve}/affectations", "as" => "eleves.affectations."], function () {
        // Affectation d'un responsable
        Route::group(["prefix" => "responsables", "as" => "responsables."], function () {
            Route::get("/", "Scolarite\Affectations\AffectationResponsableController@index")->name("index");
            Route::post("{responsable}", "Scolarite\Affectations\AffectationResponsableController@attach")->name("attach");
            Route::delete("{responsable}", "Scolarite\Affectations\AffectationResponsableController@detach")->name("detach");
        });

        //Affectation d'un matériel
        Route::group(["prefix" => "materiels", "as" => "materiels."], function () {
            Route::get("/", "Scolarite\Affectations\AffectationMaterielController@index")->name("index");
            Route::post("/{materiel}", "Scolarite\Affectations\AffectationMaterielController@attach")->name("attach");
            Route::delete("/{materiel}", "Scolarite\Affectations\AffectationMaterielController@detach")->name("detach");
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

	Route::group(["prefix" => "/materiels", "as" => "materiels."], function () {
		Route::resource("etats", "Administrations\Materiels\EtatController");
	});
});