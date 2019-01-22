<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{

	protected $services = [
		"Administrateur" => "Possède tout les droits sur l'application",
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

				foreach ($permissions as $permission) {
					$service->permissions()->attach($permission);
				}
			}
		}
	}
}
