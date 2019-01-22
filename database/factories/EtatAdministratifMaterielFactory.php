<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\EtatAdministratifMateriel::class, function (Faker $faker) {
	return [
		"libelle" => $faker->word,
		"couleur" => $faker->hexColor,
	];
});
