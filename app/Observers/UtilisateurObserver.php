<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Session;

class UtilisateurObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un utilisateur
	 *
	 * @param Utilisateur $utilisateur
	 */
	public function created(Utilisateur $utilisateur)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"utilisateur_id" => $utilisateur->id,
				"type"           => "utilisateur/created",
				"information"    => "L'utilisateur {$utilisateur->nom} {$utilisateur->prenom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un utilisateur
	 *
	 * @param Utilisateur $utilisateur
	 */
	public function updated(Utilisateur $utilisateur)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"utilisateur_id" => $utilisateur->id,
				"type"           => "utilisateur/modified",
				"information"    => "L'utilisateur {$utilisateur->nom} {$utilisateur->prenom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un utilisateur
	 *
	 * @param Utilisateur $utilisateur
	 */
	public function deleted(Utilisateur $utilisateur)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "utilisateur/deleted",
				"information" => "L'utilisateur {$utilisateur->nom} {$utilisateur->prenom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>