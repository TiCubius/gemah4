<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Materiel::class, function(Faker $faker) {
	return [
		"type_id"    => 1,
		"marque"     => $faker->word,
		"modele"     => $faker->word,
		"prix_ttc"   => $faker->numberBetween(0, 1000),
		"etat_id"    => 1,
	];
});
