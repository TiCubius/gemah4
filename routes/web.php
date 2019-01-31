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

Route::get('/connexion', 'ConnexionController@index')->name('web.connexion');
Route::post('/connexion', 'ConnexionController@login');
Route::get('/deconnexion', 'ConnexionController@logout')->name('web.logout');

Route::group(["middleware" => ["authentification", "permissions"]], function () {
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

		Route::group(["prefix" => "eleves/{eleve}/affectations", "as" => "eleves.affectations."], function () {
			//Affectation d'un établissement
			Route::group(["prefix" => "etablissements", "as" => "etablissements."], function () {
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
				Route::get("/create", "Scolarites\Affectations\ResponsableController@create")->name("create");
				Route::post("/", "Scolarites\Affectations\ResponsableController@store")->name("store");
				Route::patch("{responsable}", "Scolarites\Affectations\ResponsableController@attach")->name("attach");
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

	Route::group(["prefix" => "/administrations", "as" => "web.administrations."], function () {
		Route::resource("/", "Administrations\AdministrationController")->only("index");

		Route::resource("departements", "Administrations\DepartementController");
		Route::resource("academies", "Administrations\AcademieController")->parameters([
			"academies" => "academie"
		]);
		Route::resource("regions", "Administrations\RegionController");

		Route::get("parametres/edit", "Administrations\ParametreController@edit")->name("parametres.edit");
		Route::patch("parametres", "Administrations\ParametreController@update")->name("parametres.update");

		Route::resource("services", "Administrations\ServiceController");
		Route::resource("utilisateurs", "Administrations\UtilisateurController");


		Route::group(["prefix" => "/materiels", "as" => "materiels."], function () {
			Route::group(["prefix" => "/etats", "as" => "etats."], function () {
				Route::resource("administratifs", "Administrations\Materiels\EtatAdministratifMaterielController");
				Route::resource("physiques", "Administrations\Materiels\EtatPhysiqueMaterielController");
			});
		});

		Route::group(["prefix" => "/types", "as" => "types."], function () {
			Route::resource("tickets", "Administrations\Types\TypeTicketController");
			Route::resource("etablissements", "Administrations\Types\TypeEtablissementController");
			Route::resource("decisions", "Administrations\Types\TypeDecisionController")->parameters([
				'decisions' => 'decision',
			]);
			Route::resource("documents", "Administrations\Types\TypeDocumentController");
		});

		Route::resource("historiques", "Administrations\HistoriqueController")->only(["index", "show"]);
	});

	Route::group(["prefix" => "/conventions", "as" => "web.conventions."], function () {
		Route::get("/", "Responsables\ConventionController@index")->name("index");
		Route::patch("/", "Responsables\ConventionController@update")->name("update");
		Route::get("signatures_effectues", "Responsables\ConventionController@signaturesEffectuees")->name("signatures_effectuees");
		Route::get("signatures_manquantes", "Responsables\ConventionController@signaturesManquantes")->name("signatures_manquantes");
		Route::get("impressions_toutes_conventions", "Responsables\ConventionController@impressionsToutesConventions")->name("impressions_toutes_conventions");
	});

	Route::group(["prefix" => "/statistiques", "as" => "web.statistiques."], function () {
		Route::get("/", "Statistiques\StatistiquesController@index")->name("index");
		Route::get("/generale", "Statistiques\StatistiquesController@generale")->name("generale");
	});
});