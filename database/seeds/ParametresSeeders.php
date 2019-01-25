<?php

use Illuminate\Database\Seeder;

class ParametresSeeders extends Seeder
{
	private $departements = [
		"42" => [
			[
				"libelle" => "Affaire suivie par",
				"key"     => "conventions/affaire/convention/nom",
				"value"   => "DECHAVANNE Béatrice",
			],
			[
				"libelle" => "Téléphone",
				"key"     => "conventions/affaire/convention/telephone",
				"value"   => "04 77 81 41 13",
			],
			[
				"libelle" => "E-Mail",
				"key"     => "conventions/affaire/convention/email",
				"value"   => "",
			],
			[
				"libelle" => "Affaire suivie par",
				"key"     => "conventions/affaire/informatique/nom",
				"value"   => "GOUNON Jean-Jacques",
			],
			[
				"libelle" => "Téléphone",
				"key"     => "conventions/affaire/informatique/telephone",
				"value"   => "04 77 81 79 47",
			],
			[
				"libelle" => "E-Mail",
				"key"     => "conventions/affaire/informatique/email",
				"value"   => "",
			],
			[
				"libelle" => "Affaire suivie par",
				"key"     => "conventions/affaire/audio/nom",
				"value"   => "GAVILLET Annick",
			],
			[
				"libelle" => "Téléphone",
				"key"     => "conventions/affaire/audio/telephone",
				"value"   => "04 77 81 41 38",
			],
			[
				"libelle" => "E-Mail",
				"key"     => "conventions/affaire/audio/email",
				"value"   => "",
			],
			[
				"libelle" => "Secrétaire général",
				"key"     => "conventions/secretaire",
				"value"   => "Jean-Luc POUMAREDES",
			],
			[
				"libelle" => "Adresse",
				"key"     => "conventions/adresse",
				"value"   => "11, rue des Docteurs Charcot",
			],
			[
				"libelle" => "Code Postal",
				"key"     => "conventions/code_postal",
				"value"   => "42023",
			],
			[
				"libelle" => "Ville",
				"key"     => "conventions/ville",
				"value"   => "Saint-Etienne",
			],
			[
				"libelle" => "Année scolaire",
				"key"     => "conventions/annee",
				"value"   => "2018 / 2019",
			],
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
			foreach ($keys as $data) {
				\App\Models\Parametre::create([
					"departement_id" => $departement,
					"libelle"        => $data["libelle"],
					"key"            => $data["key"],
					"value"          => $data["value"],
				]);
			}
		}
	}
}
