<?php

namespace App\Http\Middleware;

use App\Models\Utilisateur;
use Closure;
use Hamcrest\Util;
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


		"App\Http\Controllers\Responsables\ConventionController"  => "conventions/",
		"App\Http\Controllers\Responsables\ResponsableController" => "responsables/",

		"App\Http\Controllers\Scolarites\Affectations\EtablissementController" => "affectations/etablissements/",
		"App\Http\Controllers\Scolarites\Affectations\MaterielController"      => "affectations/materiels/",
		"App\Http\Controllers\Scolarites\Affectations\ResponsableController"   => "affectations/responsables/",


		"App\Http\Controllers\Scolarites\Documents\DecisionController"   => "eleves/decisions/",
		"App\Http\Controllers\Scolarites\Documents\DocumentController"   => "eleves/documents/",
		"App\Http\Controllers\Scolarites\Documents\ImpressionController" => "eleves/impressions/",

		"App\Http\Controllers\Scolarites\EleveController"         => "eleves/",
		"App\Http\Controllers\Scolarites\EnseignantController"    => "enseignants/",
		"App\Http\Controllers\Scolarites\EtablissementController" => "etablissements/",
		"App\Http\Controllers\Scolarites\ScolariteController"     => "scolarites/",
		"App\Http\Controllers\Scolarites\TicketController"        => "eleves/tickets/",
		"App\Http\Controllers\Scolarites\TicketMessageController" => "eleves/tickets/messages/",

		"App\Http\Controllers\ConnexionController" => null,
		"App\Http\Controllers\GemahController"     => null,
	];

	/**
	 * Vérifie que le contrôleur a bien été ajouté dans le tableau ci-dessus
	 *
	 * @param string $controller
	 * @return bool
	 */
	private function permissionExistsForController(string $controller): bool
	{
		return array_key_exists($controller, $this->permissions);
	}

	/**
	 * Vérifie qu'une permission est nécessaire pour accéder à cette ressource
	 *
	 * @param string $controller
	 * @return bool
	 */
	private function permissionRequiredForController(string $controller): bool
	{
		return $this->permissions[$controller] !== null;
	}

	/**
	 * Vérifie que l'utilisateur possède bien la permission demandée
	 *
	 * @param Utilisateur $user
	 * @param string      $permission
	 * @return bool
	 */
	private function userHasPermission(Utilisateur $user, string $permission): bool {
		return $user->service->permissions->contains("id", $permission);
	}

	/**
	 * Handle an incoming request/
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Récupération des informations
		$routeAction = Route::currentRouteAction();
		$controller = explode("@", $routeAction)[0];
		$method = explode("@", $routeAction)[1];

		// Si un utilisateur a la méthode pour "create" ou "edit", il devrait pouvoir soumettre le formulaire
		$method = ($method == "store") ? "create" : $method;
		$method = ($method == "update") ? "edit" : $method;

		// On vérifie :
		// - Que le contrôleur est dans le tableau $permissions
		// - Que la permission nécessaire pour le contrôleur est différent de null
		// - Que l'utilisateur possède la permission pour la méthode de ce contrôleur
		if (!$this->permissionExistsForController($controller)) {
			return back()->withErrors("Aucune permission n'existe pour cette page !");
		}

		if ($this->permissionRequiredForController($controller)) {
			$permission = $this->permissions[$controller] . $method;

			debug("[PERM] - Vérification d'accès...");
			debug("[PERM] - controller: {$controller}");
			debug("[PERM] - permission: {$permission}");

			$user = Session::get("user");
			if (!$this->userHasPermission($user, $permission)) {
				return back()->withErrors("Vous n'avez pas la permission requise pour accéder à cette ressource.");
			}
		}

		return $next($request);
	}
}
