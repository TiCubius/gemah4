<?php

namespace App\Observers;

use App\Models\EtatPhysiqueMateriel;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class EtatPhysiqueMaterielObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un état physique matériel
	 *
	 * @param EtatPhysiqueMateriel $etatPhysiqueMateriel
	 */
	public function created(EtatPhysiqueMateriel $etatPhysiqueMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"                   => $user->id,
				"etat_physique_materiel_id" => $etatPhysiqueMateriel->id,
				"type"                      => "etat/physique/materiel/created",
				"information"               => "L'état physique matériel {$etatPhysiqueMateriel->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un état physique matériel
	 *
	 * @param EtatPhysiqueMateriel $etatPhysiqueMateriel
	 */
	public function updated(EtatPhysiqueMateriel $etatPhysiqueMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"                   => $user->id,
				"etat_physique_materiel_id" => $etatPhysiqueMateriel->id,
				"type"                      => "etat/physique/materiel/modified",
				"information"               => "L'état physique matériel {$etatPhysiqueMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un état physique matériel
	 *
	 * @param EtatPhysiqueMateriel $etatPhysiqueMateriel
	 */
	public function deleted(EtatPhysiqueMateriel $etatPhysiqueMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "etat/physique/materiel/deleted",
				"information" => "L'état physique matériel {$etatPhysiqueMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>