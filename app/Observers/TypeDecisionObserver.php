<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeDecision;
use Illuminate\Support\Facades\Session;

class TypeDecisionObserver
{
	/***
	 * Ajoute une ligne à l'historique dès qu'un type de décision est créé
	 *
	 * @param TypeDecision $typeDecision
	 */
	public function created(TypeDecision $typeDecision)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"          => $user["id"],
				"type_decision_id" => $typeDecision->id,
				"type"             => "type/decision/created",
				"contenue"         => "Le type de décision {$typeDecision->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un type de décision est modifié
	 *
	 * @param TypeDecision $typeDecision
	 */
	public function updated(TypeDecision $typeDecision)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"          => $user["id"],
				"type_decision_id" => $typeDecision->id,
				"type"             => "type/decision/modified",
				"contenue"         => "Le type de décision {$typeDecision->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un type de décision est supprimé
	 *
	 * @param TypeDecision $typeDecision
	 */
	public function deleted(TypeDecision $typeDecision)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"type"     => "type/decision/deleted",
				"contenue" => "Le type de décision {$typeDecision->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}