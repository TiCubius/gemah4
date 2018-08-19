<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Academie::class, function(Faker $faker) {
	return [
		"nom"       => $faker->word,
		"region_id" => 1,
	];
});
