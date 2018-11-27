<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Materiel::class, function(Faker $faker) {
	$type = factory(\App\Models\TypeMateriel::class)->create();
	$etat = factory(\App\Models\EtatMateriel::class)->create();

	return [
		"type_id"    => $type->id,
		"marque"     => $faker->word,
		"modele"     => $faker->word,
		"prix_ttc"   => $faker->numberBetween(0, 1000),
		"etat_id"    => $etat->id,
	];
});
