<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Materiel::class, function(Faker $faker) {
	$type = factory(\App\Models\TypeMateriel::class)->create();
	$etat = factory(\App\Models\EtatMateriel::class)->create();
	$departement = factory(\App\Models\Departement::class)->create();

	return [
		"type_id"         => $type->id,
        "num_serie"       => $faker->word,
		"marque"          => $faker->word,
		"modele"          => $faker->word,
		"prix_ttc"        => $faker->numberBetween(0, 1000),
        "nom_fournisseur" => $faker->name,
		"etat_id"         => $etat->id,
        "num_devis"       => $faker->numberBetween(0, 1000),
		"departement_id"  => $departement->id,

        "num_formulaire_chorus" => $faker->numberBetween(0, 100),
	];
});
