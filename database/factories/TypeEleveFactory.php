<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\TypeEleve::class, function (Faker $faker) {
	return [
		"libelle" => $faker->word,
	];
});
