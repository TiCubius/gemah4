<?php

namespace App\Observers;

use App\Models\Departement;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class DepartementObserver
{
	/***
	 * Ajoute une ligne à l'historique dès qu'un département est créé
	 *
	 * @param Departement $departement
	 */
	public function created(Departement $departement)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"        => $user["id"],
				"departement_id" => $departement->id,
				"type"           => "departement/created",
				"contenue"       => "Le département {$departement->nom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un département est modifié
	 *
	 * @param Departement $departement
	 */
	public function updated(Departement $departement)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"        => $user["id"],
				"departement_id" => $departement->id,
				"type"           => "departement/modified",
				"contenue"       => "Le département {$departement->nom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un département est supprimé
	 *
	 * @param Departement $departement
	 */
	public function deleted(Departement $departement)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"type"     => "departement/deleted",
				"contenue" => "Le département {$departement->nom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>