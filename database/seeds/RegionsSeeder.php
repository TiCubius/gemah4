<?php

use Illuminate\Database\Seeder;

class RegionsSeeder extends Seeder
{

	private $regions = [
		"Auvergne-Rhône-Alpes",
		"Bourgogne-Franche-Comté",
		"Bretagne",
		"Centre-Val de Loire",
		"Corse",
		"Grand Est",
		"Guadeloupe",
		"Guyane",
		"Hauts-de-France",
		"Île-de-France",
		"Martinique",
		"Normandie",
		"Nouvelle-Aquitaine",
		"Occitanie",
		"Pays de la Loire",
		"Provence-Alpes-Côte d'Azur",
		"La Réunion",
		"Mayotte",
		"Polynésie Française",
		"Nouvelle-Calédonie",
		"Autres Régions",
	];

	public function run()
	{
		foreach ($this->regions as $region) {
			\App\Models\Region::updateOrCreate([
				'nom' => $region,
			]);
		}
	}

}
