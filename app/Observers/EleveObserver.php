<?php

namespace App\Observers;

use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class EleveObserver
{
	/***
	 * Ajoute une ligne à l'historique dès qu'un élève est créé
	 *
	 * @param Eleve $eleve
	 */
	public function created(Eleve $eleve)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"eleve_id" => $eleve->id,
				"type"     => "eleve/created",
				"contenue" => "L'élève {$eleve->nom} {$eleve->prenom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un élève est modifié
	 *
	 * @param Eleve $eleve
	 */
	public function updated(Eleve $eleve)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"eleve_id" => $eleve->id,
				"type"     => "eleve/modified",
				"contenue" => "L'élève {$eleve->nom} {$eleve->prenom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un élève est supprimé
	 *
	 * @param Eleve $eleve
	 */
	public function deleted(Eleve $eleve)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"type"     => "eleve/deleted",
				"contenue" => "L'élève {$eleve->nom} {$eleve->prenom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>