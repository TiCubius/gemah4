<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TypeDocument::class, function (Faker $faker) {
	return [
		"libelle" => $faker->word,
	];
});
