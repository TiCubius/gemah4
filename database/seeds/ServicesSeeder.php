<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{

	protected $services = [
		"Administrateur"       => "Possède tout les droits sur l'application",
		"ASH"                  => "Gestion des élèves en situation de handicap",
		"DAF"                  => "Division des Affaires Financières",
		"DIVEL"                => "Division des élèves",
		"Service Informatique" => "",
	];

	/**
	 *
	 * Utilisateurs :
	 * - ADMIN: Admin                | admin             | goddess
	 * - ASH : CHADUC Pierre-Henri   | pchaduc           | ?chaduc
	 * - DAF : GAVILLET Annick       | agavillet         | agavillet
	 * - DIVEL : DECHAVANNE Béatrice | bdechavanne | bdechavanne
	 *
	 */

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
