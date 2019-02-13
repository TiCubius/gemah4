<?php

use Illuminate\Database\Seeder;

class DomainesMaterielSeeder extends Seeder
{
	private $domaines = [
		"Audio",
		"Informatique",
		"Logiciel",
		"GEMAH2"
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach ($this->domaines as $domaine) {
			\App\Models\DomaineMateriel::updateOrCreate([
				"libelle" => $domaine,
			]);
		}
	}
}
