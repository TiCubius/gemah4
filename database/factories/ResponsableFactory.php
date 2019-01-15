<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Responsable::class, function(Faker $faker) {
    $departement = factory(\App\Models\Departement::class)->create();

	return [
		"civilite"      => $faker->randomElement(['M', 'Mme', 'M/Mme']),
		"nom"           => $faker->word,
		"prenom"        => $faker->word,
		"code_postal"   => $faker->randomNumber(5, true),
		"adresse"       => $faker->streetAddress,
		"ville"         => $faker->city,
		"telephone"     => $faker->randomNumber(9, true),
		"email"         => $faker->safeEmail,
		"created_at"    => $faker->date(),
		"updated_at"    => $faker->date(),
        "departement_id"=> $departement->id,
	];


});