<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\TypeTicket::class, function(Faker $faker) {
	return [
		"libelle" => $faker->word,
	];
});
