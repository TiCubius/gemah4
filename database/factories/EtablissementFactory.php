<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Etablissement::class, function(Faker $faker) {
	$enseignant = factory(\App\Models\Enseignant::class)->create();
	$academy = factory(\App\Models\Academie::class)->create();

	return [
		"id"            => $faker->randomNumber(9, true),
		"nom"           => $faker->word,
		"type"          => $faker->word,
		"degre"         => $faker->word,
		"regime"        => $faker->word,
		"ville"         => $faker->city,
		"code_postal"   => $faker->randomNumber(5, true),
		"adresse"       => $faker->streetAddress,
		"telephone"     => $faker->randomNumber(9, true),
		"enseignant_id" => $enseignant->id,
		"academie_id"   => $academy->id,
	];
});
