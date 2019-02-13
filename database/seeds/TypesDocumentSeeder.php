<?php

use Illuminate\Database\Seeder;

class TypesDocumentSeeder extends Seeder
{
	protected $types = [
		"Décision",
		"Autre document",
	];

	public function run()
	{
		foreach ($this->types as $type) {
			\App\Models\TypeDocument::updateOrCreate([
				'libelle' => $type,
			]);
		}
	}
}
