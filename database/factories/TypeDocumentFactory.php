<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TypeDocument::class, function(Faker $faker) {
	return [
		"nom" => $faker->word,
	];
});
