<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Responsable;
use Illuminate\Support\Facades\Session;

class ResponsableObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un responsable
	 *
	 * @param Responsable $responsable
	 */
	public function created(Responsable $responsable)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"responsable_id" => $responsable->id,
				"type"           => "responsable/created",
				"information"    => "Le responsable {$responsable->nom} {$responsable->prenom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un responsable
	 *
	 * @param Responsable $responsable
	 */
	public function updated(Responsable $responsable)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"responsable_id" => $responsable->id,
				"type"           => "responsable/modified",
				"information"    => "Le responsable {$responsable->nom} {$responsable->prenom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un responsable
	 *
	 * @param Responsable $responsable
	 */
	public function deleted(Responsable $responsable)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "responsable/deleted",
				"information" => "Le responsable {$responsable->nom} {$responsable->prenom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>