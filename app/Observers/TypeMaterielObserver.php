<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeMateriel;
use Illuminate\Support\Facades\Session;

class TypeMaterielObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un type de matériel
	 *
	 * @param TypeMateriel $typeMateriel
	 */
	public function created(TypeMateriel $typeMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"type_materiel_id" => $typeMateriel->id,
				"type"             => "type/materiel/created",
				"information"      => "Le type de matériel {$typeMateriel->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un type de matériel
	 *
	 * @param TypeMateriel $typeMateriel
	 */
	public function updated(TypeMateriel $typeMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"type_materiel_id" => $typeMateriel->id,
				"type"             => "type/materiel/modified",
				"information"      => "Le type de matériel {$typeMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un type de matériel
	 *
	 * @param TypeMateriel $typeMateriel
	 */
	public function deleted(TypeMateriel $typeMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "type/materiel/deleted",
				"information" => "Le type de matériel {$typeMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>