<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Region;
use Illuminate\Support\Facades\Session;

class RegionObserver
{
	/***
	 * EVENT - Déchlanché après la création d'une région
	 *
	 * @param Region $region
	 */
	public function created(Region $region)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"region_id"   => $region->id,
				"type"        => "region/created",
				"information" => "La région {$region->nom} à été créée par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'une région
	 *
	 * @param Region $region
	 */
	public function updated(Region $region)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"region_id"   => $region->id,
				"type"        => "region/modified",
				"information" => "La région {$region->nom} à été modifiée par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'une région
	 *
	 * @param Region $region
	 */
	public function deleted(Region $region)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "region/deleted",
				"information" => "La région {$region->nom} à été supprimée par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>