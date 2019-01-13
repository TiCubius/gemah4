<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Service::class, function(Faker $faker) {
    $departement = factory(\App\Models\Departement::class)->create();
	return [
		"nom"         => $faker->word,
		"description" => $faker->sentence,
        "departement_id" => $departement->id,
	];
});
