<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class ServiceObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un service
	 *
	 * @param Service $service
	 */
	public function created(Service $service)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"service_id"  => $service->id,
				"type"        => "service/created",
				"information" => "Le service {$service->nom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un service
	 *
	 * @param Service $service
	 */
	public function updated(Service $service)
	{
		// Change le "updated_at" de tout les utilisateurs dans ce service
		$service->utilisateurs()->touch();

		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"service_id"  => $service->id,
				"type"        => "service/modified",
				"information" => "Le service {$service->nom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un service
	 *
	 * @param Service $service
	 */
	public function deleting(Service $service)
	{
		// Supprime toutes les permissions associés
		$service->permissions()->detach();
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un service
	 *
	 * @param Service $service
	 */
	public function deleted(Service $service)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "service/deleted",
				"information" => "Le service {$service->nom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>