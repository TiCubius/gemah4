<?php

use Illuminate\Database\Seeder;

class ParametresSeeders extends Seeder
{
	private $departements = [
		"42" => [
			"conventions/affaire/nom"            => "BELMIRO Virginie",
			"conventions/affaire/telephone"      => "04 77 81 41 13",
			"conventions/informatique/nom"       => "GOUNON Jean-Jacques",
			"conventions/informatique/telephone" => "04 77 81 79 47",
			"conventions/audio/nom"              => "GAVILLET Annick",
			"conventions/audio/telephone"        => "04 77 81 41 38",
			"conventions/adresse"                => "11, rue des Docteurs Charcot",
			"conventions/secretaire"             => "Jean-Luc POUMAREDES",
			"conventions/code_postal"            => "42023",
			"conventions/ville"                  => "Saint-Etienne",
		],
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach ($this->departements as $departement => $keys) {
			foreach ($keys as $key => $value) {
				\App\Models\Parametre::create([
					"departement_id" => $departement,
					"key"            => $key,
					"value"          => $value,
				]);
			}
		}
	}
}
