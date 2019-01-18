<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TypeMateriel::class, function (Faker $faker) {
	$domaine = factory(\App\Models\DomaineMateriel::class)->create();

	return [
		"libelle"    => $faker->word,
		"domaine_id" => $domaine->id,
	];
});
