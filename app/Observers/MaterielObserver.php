<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Materiel;
use Illuminate\Support\Facades\Session;

class MaterielObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un matériel
	 *
	 * @param Materiel $materiel
	 */
	public function created(Materiel $materiel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"materiel_id" => $materiel->id,
				"type"        => "materiel/created",
				"information" => "Le matériel {$materiel->modele} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un matériel
	 *
	 * @param Materiel $materiel
	 */
	public function updated(Materiel $materiel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"materiel_id" => $materiel->id,
				"type"        => "materiel/modified",
				"information" => "Le matériel {$materiel->modele} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un matériel
	 *
	 * @param Materiel $materiel
	 */
	public function deleted(Materiel $materiel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "materiel/deleted",
				"information" => "Le matériel {$materiel->modele} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>