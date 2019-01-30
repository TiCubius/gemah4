<?php

namespace App\Providers;

use App\Models\Enseignant;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class EnseignantObserver
{
	/***
	 * Ajoute une ligne à l'historique dès qu'un enseignant est créé
	 *
	 * @param Enseignant $enseignant
	 */
	public function created(Enseignant $enseignant)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"       => $user["id"],
				"enseignant_id" => $enseignant->id,
				"type"          => "enseignant/created",
				"contenue"      => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un enseignant est modifié
	 *
	 * @param Enseignant $enseignant
	 */
	public function updated(Enseignant $enseignant)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"       => $user["id"],
				"enseignant_id" => $enseignant->id,
				"type"          => "enseignant/modified",
				"contenue"      => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un enseignant est supprimé
	 *
	 * @param Enseignant $enseignant
	 */
	public function deleted(Enseignant $enseignant)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"type"     => "enseignant/deleted",
				"contenue" => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}