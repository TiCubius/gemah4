<?php

namespace App\Observers;

use App\Models\DomaineMateriel;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class DomaineMaterielObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un domaine matériel
	 *
	 * @param DomaineMateriel $domaineMateriel
	 */
	public function created(DomaineMateriel $domaineMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"domaine_id"  => $domaineMateriel->id,
				"type"        => "domaine/materiel/created",
				"information" => "Le domaine {$domaineMateriel->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un domaine matériel
	 *
	 * @param DomaineMateriel $domaineMateriel
	 */
	public function updated(DomaineMateriel $domaineMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"domaine_id"  => $domaineMateriel->id,
				"type"        => "domaine/materiel/modified",
				"information" => "Le domaine {$domaineMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un domaine matériel
	 *
	 * @param DomaineMateriel $domaineMateriel
	 */
	public function deleted(DomaineMateriel $domaineMateriel)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "domaine/materiel/deleted",
				"information" => "Le domaine {$domaineMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>