<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\TypeDecision::class, function (Faker $faker) {
	return [
		"libelle" => $faker->word,
	];
});
