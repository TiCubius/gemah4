<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{

	protected $services = [
		"Administrateur"       => "Gestion de GEMAH",
		"ASH"                  => "Gestion des élèves en situation de handicap",
		"DAF"                  => "Division des affaires financiaires",
		"DIDEL"                => "Division des élèves",
		"Service informatique" => "Gestion du système informatique",
	];

	public function run()
	{
		$permissions = \App\Models\Permission::all();

		foreach (\App\Models\Departement::all() as $departement) {
			foreach ($this->services as $service => $description) {
				$service = \App\Models\Service::create([
					"nom"            => $service,
					"description"    => $description,
					"departement_id" => $departement->id,
				]);

				if ($service == "Administrateur") {
					foreach ($permissions as $permission) {
						$service->permissions()->attach($permission);
					}
				}
			}
		}
	}
}
