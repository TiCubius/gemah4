<?php

use Illuminate\Database\Seeder;

class TypesMaterielSeeder extends Seeder
{
	private $types = [
		"Audio" => [
			"Adaptateur",
			"Cordon",
			"Emetteur",
			"Micorphone",
			"Micro cravate",
			"Mini microphone",
			"Oticon",
			"Récepteur",
			"Sabot",
			"Télécommande"
		],
		"Informatique" => [
			"Casque audio",
			"Clavier Clevy",
			"Clavier",
			"Clé USB",
			"Guide doits",
			"Housse",
			"Imprimante / Scanner",
			"Imprimante",
			"Iriscan",
			"Lecteur DVD externe",
			"Logiciel",
			"Microphone",
			"Ordinateur 12\"",
			"Ordinateur 15\"",
			"Ordinateur 17\"",
			"Ordinateur Tactile",
			"Pavé numérique",
			"Sac à dos",
			"Souris",
			"Sous Scan",
			"Stylet",
			"Tablette",
			"Trackball"
		],
		"Logiciel" => [

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
        	$domaine = \App\Models\DomaineMateriel::where("nom", "=", $domaine)->first();
        	foreach ($types as $type) {
        		\App\Models\TypeMateriel::create([
        			"nom" => $type,
			        "domaine_id" => $domaine->id
		        ]);
	        }
        }
    }
}
