<?php

use Faker\Generator as Faker;

$factory->define(App\Models\DomaineMateriel::class, function(Faker $faker) {
	return [
		"libelle" => $faker->word,
	];
});
