<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Eleve::class, function(Faker $faker) {
	$etablissement = factory(\App\Models\Etablissement::class)->create();
	return [
		"nom"              => $faker->word,
		"prenom"           => $faker->word,
		"date_naissance"   => $faker->dateTimeAD,
		"classe"           => $faker->word,
		"academie_id"      => $etablissement->academie_id,
		"etablissement_id" => $etablissement->id,
		"code_ine"         => $faker->password(11, 11),
	];
});
