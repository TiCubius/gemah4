<?php

namespace App\Observers;

use App\Models\Etablissement;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class EtablissementObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un établissement
	 *
	 * @param Etablissement $etablissement
	 */
	public function created(Etablissement $etablissement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"etablissement_id" => $etablissement->id,
				"type"             => "etablissement/created",
				"information"      => "L'établissement {$etablissement->nom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un établissement
	 *
	 * @param Etablissement $etablissement
	 */
	public function updated(Etablissement $etablissement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"etablissement_id" => $etablissement->id,
				"type"             => "etablissement/modified",
				"information"      => "L'établissement {$etablissement->nom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un établissement
	 *
	 * @param Etablissement $etablissement
	 */
	public function deleted(Etablissement $etablissement)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "etablissement/deleted",
				"information" => "L'établissement {$etablissement->nom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>