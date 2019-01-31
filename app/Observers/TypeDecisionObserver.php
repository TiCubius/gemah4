<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeDecision;
use Illuminate\Support\Facades\Session;

class TypeDecisionObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un type de décision
	 *
	 * @param TypeDecision $typeDecision
	 */
	public function created(TypeDecision $typeDecision)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"type_decision_id" => $typeDecision->id,
				"type"             => "type/decision/created",
				"information"      => "Le type de décision {$typeDecision->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un type de décision
	 *
	 * @param TypeDecision $typeDecision
	 */
	public function updated(TypeDecision $typeDecision)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"type_decision_id" => $typeDecision->id,
				"type"             => "type/decision/modified",
				"information"      => "Le type de décision {$typeDecision->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la supression d'un type de décision
	 *
	 * @param TypeDecision $typeDecision
	 */
	public function deleted(TypeDecision $typeDecision)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "type/decision/deleted",
				"information" => "Le type de décision {$typeDecision->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}