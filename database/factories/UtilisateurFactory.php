<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Utilisateur::class, function(Faker $faker) {
	return [
		"nom"      => $faker->word,
		"prenom"   => $faker->word,
		"email"    => $faker->safeEmail,
		"password" => \Illuminate\Support\Facades\Hash::make($faker->password),

		"academie_id" => 1,
		"service_id"  => 1,
	];
});
