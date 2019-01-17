<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\TypeEtablissement::class, function(Faker $faker) {
	return [
		"libelle" => $faker->word,
	];
});
