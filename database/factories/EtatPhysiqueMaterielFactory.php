<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\EtatPhysiqueMateriel::class, function (Faker $faker) {
	return [
		"libelle" => $faker->word,
	];
});
