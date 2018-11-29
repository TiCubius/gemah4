<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Etablissement::class, function(Faker $faker) {
	$enseignant = factory(\App\Models\Enseignant::class)->create();
	$academy = factory(\App\Models\Academie::class)->create();

	return [
		"id"            => $faker->name,
		"nom"           => $faker->name,
		"type"          => $faker->name,
		"degre"         => $faker->name,
		"regime"        => $faker->name,
		"ville"         => $faker->city,
		"code_postal"   => $faker->randomNumber(5, true),
		"adresse"       => $faker->address,
		"telephone"     => $faker->randomNumber(9, true),
		"enseignant_id" => $enseignant->id,
		"academie_id"   => $academy->id,
	];
});
