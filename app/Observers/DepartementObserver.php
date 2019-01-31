<?php

namespace App\Observers;

use App\Models\Departement;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class DepartementObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un département
	 *
	 * @param Departement $departement
	 */
	public function created(Departement $departement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"departement_id" => $departement->id,
				"type"           => "departement/created",
				"information"    => "Le département {$departement->nom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un département
	 *
	 * @param Departement $departement
	 */
	public function updated(Departement $departement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"departement_id" => $departement->id,
				"type"           => "departement/modified",
				"information"    => "Le département {$departement->nom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un département
	 *
	 * @param Departement $departement
	 */
	public function deleted(Departement $departement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "departement/deleted",
				"information" => "Le département {$departement->nom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>