<?php

use Illuminate\Database\Seeder;

class EtatsAdministratifsMaterielSeeder extends Seeder
{
	private $etats = [
	    ["Neuf", "#00bb00"],
		["Occasion", "#555500"],
		["En panne", "#9b6039"],
		["Volé", "#9b3939"],
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach ($this->etats as $etat) {
			\App\Models\EtatAdministratifMateriel::create([
				"libelle" => $etat[0],
				"couleur" => $etat[1],
			]);
		}
	}
}
