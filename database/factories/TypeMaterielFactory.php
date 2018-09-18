<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TypeMateriel::class, function(Faker $faker) {
	return [
		"nom"        => $faker->word,
		"domaine_id" => 1,
	];
});
