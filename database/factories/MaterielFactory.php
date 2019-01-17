<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Materiel::class, function (Faker $faker) {
	$type = factory(\App\Models\TypeMateriel::class)->create();
    $etat_administratif = factory(\App\Models\EtatAdministratifMateriel::class)->create();
    $etat_physique = factory(\App\Models\EtatPhysiqueMateriel::class)->create();
	$departement = factory(\App\Models\Departement::class)->create();

	return [
		"type_materiel_id" => $type->id,
		"numero_serie"        => $faker->word,
		"marque"           => $faker->word,
		"modele"           => $faker->word,
		"prix_ttc"         => $faker->numberBetween(0, 1000),
		"nom_fournisseur"  => $faker->name,
        "etat_administratif_materiel_id" => $etat_administratif->id,
		"etat_physique_materiel_id" => $etat_physique->id,
		"numero_devis"        => $faker->numberBetween(0, 1000),
		"departement_id"   => $departement->id,

		"numero_formulaire_chorus" => $faker->numberBetween(0, 100),
	];
});
