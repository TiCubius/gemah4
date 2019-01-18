<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Materiel::class, function (Faker $faker) {
	$type = factory(\App\Models\TypeMateriel::class)->create();
	$etat = factory(\App\Models\EtatMateriel::class)->create();
	$departement = factory(\App\Models\Departement::class)->create();

	return [
		"type_materiel_id" => $type->id,
		"numero_serie"        => $faker->word,
		"marque"           => $faker->word,
		"modele"           => $faker->word,
		"prix_ttc"         => $faker->numberBetween(0, 1000),
		"nom_fournisseur"  => $faker->name,
		"etat_materiel_id" => $etat->id,
		"numero_devis"        => $faker->numberBetween(0, 1000),
		"departement_id"   => $departement->id,

		"numero_formulaire_chorus" => $faker->numberBetween(0, 100),
	];
});
