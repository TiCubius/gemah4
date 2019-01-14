<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\TypeEtablissement::class, function(Faker $faker) {
	return [
		"nom" => $faker->word,
	];
});
