<?php

namespace App\Observers;

use App\Models\Academie;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;

class AcademieObserver
{
	/***
	 * EVENT - Déchlanché après la création d'une académie
	 *
	 * @param Academie $academie
	 */
	public function created(Academie $academie)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"academie_id" => $academie->id,
				"type"        => "academie/created",
				"information" => "L'académie {$academie->nom} à été créée par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'une académie
	 *
	 * @param Academie $academie
	 */
	public function updated(Academie $academie)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"academie_id" => $academie->id,
				"type"        => "academie/modified",
				"information" => "L'académie {$academie->nom} à été modifiée par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'une académie
	 *
	 * @param Academie $academie
	 */
	public function deleted(Academie $academie)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "academie/deleted",
				"information" => "L'académie {$academie->nom} à été supprimée par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>