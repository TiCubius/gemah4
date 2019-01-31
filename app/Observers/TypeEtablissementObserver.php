<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeEtablissement;
use Illuminate\Support\Facades\Session;

class TypeEtablissementObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un type d'établissement
	 *
	 * @param TypeEtablissement $typeEtablissement
	 */
	public function created(TypeEtablissement $typeEtablissement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"               => $user->id,
				"type_etablissement_id" => $typeEtablissement->id,
				"type"                  => "type/etablissement/created",
				"information"           => "Le type d'établissement {$typeEtablissement->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un type d'établissement
	 *
	 * @param TypeEtablissement $typeEtablissement
	 */
	public function updated(TypeEtablissement $typeEtablissement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"               => $user->id,
				"type_etablissement_id" => $typeEtablissement->id,
				"type"                  => "type/etablissement/modified",
				"information"           => "Le type d'établissement {$typeEtablissement->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un type d'établissement
	 *
	 * @param TypeEtablissement $typeEtablissement
	 */
	public function deleted(TypeEtablissement $typeEtablissement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "type/etablissement/deleted",
				"information" => "Le type d'établissement {$typeEtablissement->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>