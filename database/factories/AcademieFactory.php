<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Academie::class, function(Faker $faker) {
	$region = factory(\App\Models\Region::class)->create();

	return [
		"nom"       => $faker->word,
		"region_id" => $region->id,
	];
});
