<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Eleve::class, function(Faker $faker) {
	$departement = factory(App\Models\Departement::class)->create();

	return [
		"nom"              => $faker->word,
		"prenom"           => $faker->word,
		"date_naissance"   => $faker->dateTimeAD,
		"classe"           => $faker->word,
		"departement_id"   => $departement->id,
		"code_ine"         => random_int(1000000000, 9999999999),
	];
});
