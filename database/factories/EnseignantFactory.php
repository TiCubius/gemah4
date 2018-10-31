<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Enseignant::class, function(Faker $faker) {
	return [
		"civilite"  => "M",
		"nom"       => $faker->word,
		"prenom"    => $faker->word,
		"email"     => $faker->email,
		"telephone" => $faker->phoneNumber,
	];
});
