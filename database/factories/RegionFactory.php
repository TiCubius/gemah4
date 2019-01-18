<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Region::class, function (Faker $faker) {
	return [
		"nom" => $faker->word,
	];
});
