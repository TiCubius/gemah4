<?php

namespace App\Providers;

use App\Models\Decision;
use App\Models\Enseignant;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class EnseignantObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un enseignant
	 *
	 * @param Enseignant $enseignant
	 */
	public function created(Enseignant $enseignant)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"       => $user->id,
				"enseignant_id" => $enseignant->id,
				"type"          => "enseignant/created",
				"information"   => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un enseignant
	 *
	 * @param Enseignant $enseignant
	 */
	public function updated(Enseignant $enseignant)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"       => $user->id,
				"enseignant_id" => $enseignant->id,
				"type"          => "enseignant/modified",
				"information"   => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/**
	 * EVENT - Déclanché lors de la suppression d'un enseignant
	 *
	 * @param Enseignant $enseignant
	 */
	public function deleting(Enseignant $enseignant)
	{
		$enseignant->decisions()->each(function (Decision $decision) {
			$decision->enseignant()->dissociate();
			$decision->save();
		});
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un enseignant
	 *
	 * @param Enseignant $enseignant
	 */
	public function deleted(Enseignant $enseignant)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "enseignant/deleted",
				"information" => "L'enseignant {$enseignant->nom} {$enseignant->prenom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}