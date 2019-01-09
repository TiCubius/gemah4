<?php

use Illuminate\Database\Seeder;

class EtatsMaterielSeeder extends Seeder
{
	private $etats = [
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
			\App\Models\EtatMateriel::create([
				"nom"     => $etat[0],
				"couleur" => $etat[1],
			]);
		}
	}
}
