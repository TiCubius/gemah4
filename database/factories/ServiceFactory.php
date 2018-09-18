<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Service::class, function(Faker $faker) {
	return [
		"nom"         => $faker->word,
		"description" => $faker->sentence,
	];
});
