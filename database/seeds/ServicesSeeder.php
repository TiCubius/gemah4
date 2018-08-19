<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{

	protected $services = [
		"Administrateur" => "Possède tout les droits sur l'application",
	];

	public function run()
	{
		foreach ($this->services as $service => $description) {
			\App\Models\Service::create([
				"nom"         => $service,
				"description" => $description,
			]);
		}
	}
}
