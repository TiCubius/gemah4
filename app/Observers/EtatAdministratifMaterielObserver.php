<?php

namespace App\Observers;

use App\Models\EtatAdministratifMateriel;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class EtatAdministratifMaterielObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un état administratif matériel
	 *
	 * @param EtatAdministratifMateriel $etatAdministratifMateriel
	 */
	public function created(EtatAdministratifMateriel $etatAdministratifMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"                        => $user->id,
				"etat_administratif_materiel_id" => $etatAdministratifMateriel->id,
				"type"                           => "etat/administratif/materiel/created",
				"information"                    => "L'état administratif matériel {$etatAdministratifMateriel->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un état administratif matériel
	 *
	 * @param EtatAdministratifMateriel $etatAdministratifMateriel
	 */
	public function updated(EtatAdministratifMateriel $etatAdministratifMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"                        => $user->id,
				"etat_administratif_materiel_id" => $etatAdministratifMateriel->id,
				"type"                           => "etat/administratif/materiel/modified",
				"information"                    => "L'état administratif matériel {$etatAdministratifMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un état adminitratif matériel
	 *
	 * @param EtatAdministratifMateriel $etatAdministratifMateriel
	 */
	public function deleted(EtatAdministratifMateriel $etatAdministratifMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "etat/administratif/materiel/deleted",
				"information" => "L'état administratif matériel {$etatAdministratifMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>