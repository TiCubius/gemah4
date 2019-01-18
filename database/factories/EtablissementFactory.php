<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Etablissement::class, function (Faker $faker) {
	$enseignant = factory(\App\Models\Enseignant::class)->create();
	$departement = factory(\App\Models\Departement::class)->create();
	$type = factory(\App\Models\TypeEtablissement::class)->create();

	return [
		"id"                    => $faker->randomNumber(9, true),
		"nom"                   => $faker->word,
		"type_etablissement_id" => $type->id,
		"degre"                 => $faker->word,
		"regime"                => $faker->word,
		"ville"                 => $faker->city,
		"code_postal"           => $faker->randomNumber(5, true),
		"adresse"               => $faker->streetAddress,
		"telephone"             => $faker->randomNumber(9, true),
		"enseignant_id"         => $enseignant->id,
		"departement_id"        => $departement->id,
	];
});
