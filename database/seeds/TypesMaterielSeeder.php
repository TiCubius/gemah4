<?php

use Illuminate\Database\Seeder;

class TypesMaterielSeeder extends Seeder
{
	private $types = [
		"Audio"        => [
			"Adaptateur",
			"Cordon",
			"Emetteur",
			"Microphone",
			"Micro cravate",
			"Mini microphone",
			"Oticon",
			"Récepteur",
			"Sabot",
			"Télécommande",
		],
		"Informatique" => [
			"Casque audio",
			"Clavier Clevy",
			"Clavier",
			"Clé USB",
			"Guide-doigts",
			"Housse",
			"Imprimante / Scanner",
			"Imprimante",
			"Iriscan",
			"Lecteur DVD externe",
			"Microphone",
			"Ordinateur 12\"",
			"Ordinateur 15\"",
			"Ordinateur 17\"",
			"Ordinateur Tactile",
			"Pavé numérique",
			"Sac à dos",
			"Souris",
			"Souris Scan",
			"Stylet",
			"Tablette",
			"Trackball",
			"Bloc notes",
		],
		"Logiciel"     => [
			"Pack Office",
			"Dragon Naturaly Speaking",
			"Lexibar",
			"Pictop",
			"Kurzwein",
			"ZoomText",
			"Antidote",
			"Cabri",
			"Geogebra",
			"Calroread",
			"Genex",
			"Woody",
			"Medialexie",
			"Tap'Touche",
            "Omnipage",
            "Claroread",
		],
		"GEMAH2"       => [
			"GEMAH2",
		],
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		foreach ($this->types as $domaine => $types) {
			$domaine = \App\Models\DomaineMateriel::where("libelle", "=", $domaine)->first();
			foreach ($types as $type) {
				\App\Models\TypeMateriel::create([
					"libelle"    => $type,
					"domaine_id" => $domaine->id,
				]);
			}
		}
	}
}
