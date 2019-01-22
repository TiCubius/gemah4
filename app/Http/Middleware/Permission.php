<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Permission
{
	private $permissions = [
		"App\Http\Controllers\Administrations\Materiels\EtatMaterielController" => "administrations/etats/materiels/",

		"App\Http\Controllers\Administrations\Types\TypeEleveController"         => "administrations/types/eleves/",
		"App\Http\Controllers\Administrations\Types\TypeEtablissementController" => "administrations/types/etablissements/",
		"App\Http\Controllers\Administrations\Types\TypeTicketController"        => "administrations/types/tickets/",

		"App\Http\Controllers\Administrations\AdministrationController" => "administrations/",

		"App\Http\Controllers\Administrations\AcademieController"    => "administrations/academies/",
		"App\Http\Controllers\Administrations\DepartementController" => "administrations/departements/",
		"App\Http\Controllers\Administrations\RegionController"      => "administrations/regions/",

		"App\Http\Controllers\Administrations\ServiceController"     => "administrations/services/",
		"App\Http\Controllers\Administrations\UtilisateurController" => "administrations/utilisateurs/",


		"App\Http\Controllers\Materiels\MaterielController"        => "materiels/",
		"App\Http\Controllers\Materiels\DomaineMaterielController" => "materiels/domaines/",
		"App\Http\Controllers\Materiels\StockMaterielController"   => "materiels/stocks/",
		"App\Http\Controllers\Materiels\TypeMaterielController"    => "materiels/types/",


		"App\Http\Controllers\Responsables\ConventionController"  => null,
		"App\Http\Controllers\Responsables\ResponsableController" => "responsables/",

		"App\Http\Controllers\Scolarites\Affectations\EtablissementController" => "affectations/etablissements/",
		"App\Http\Controllers\Scolarites\Affectations\MaterielController"      => "affectations/materiels/",
		"App\Http\Controllers\Scolarites\Affectations\ResponsableController"   => "affectations/responsables/",


		"App\Http\Controllers\Scolarites\Documents\DecisionController"   => null,
		"App\Http\Controllers\Scolarites\Documents\DocumentController"   => null,
		"App\Http\Controllers\Scolarites\Documents\ImpressionController" => null,

		"App\Http\Controllers\Scolarites\EleveController"         => "eleves/",
		"App\Http\Controllers\Scolarites\EnseignantController"    => "enseignants/",
		"App\Http\Controllers\Scolarites\EtablissementController" => "etablissements/",
		"App\Http\Controllers\Scolarites\ScolariteController"     => null,
		"App\Http\Controllers\Scolarites\TicketController"        => null,
		"App\Http\Controllers\Scolarites\TicketMessage"           => null,

		"App\Http\Controllers\ConnexionController" => null,
		"App\Http\Controllers\GemahController"     => null,
	];

	/**
	 * Handle an incoming request/
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
//		return $next($request);

		// Récupération des informations
		$routeAction = Route::currentRouteAction();
		$controller = explode("@", $routeAction)[0];
		$method = explode("@", $routeAction)[1];

		// Si un utilisateur a la méthode pour "create", il devrait pouvoir soumettre le formulaire
		// Si un utilisateur a la méthode pour "edit", il devrait pouvoir soumettre le formulaire
		$method = ($method == "store") ? "create" : $method;
		$method = ($method == "update") ? "edit" : $method;

		// On vérifie :
		// - Que le contrôleur est dans le tableau $permissions
		// - Que la permission nécessaire pour le contrôleur est différent de null
		// - Que l'utilisateur possède la permission pour la méthode de ce contrôleur
		if (array_key_exists($controller, $this->permissions) && $this->permissions[$controller] !== null) {
			debug("[PERM] - Vérification...");

			$user = Session::get("user");
			if (!$user->service->permissions->contains("id", $this->permissions[$controller] . $method)) {
				return back()->withErrors("Permission manquante");
			}

		}

		debug("[PERM] - Autorisé");
		return $next($request);
	}
}
