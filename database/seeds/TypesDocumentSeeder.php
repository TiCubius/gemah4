<?php

use Illuminate\Database\Seeder;

class TypesDocumentSeeder extends Seeder
{
	protected $types = [
		"Décision",
		"Autre",
	];

	public function run()
	{
		foreach ($this->types as $type) {
			\App\Models\TypeDocument::create([
				'libelle' => $type,
			]);
		}
	}
}
