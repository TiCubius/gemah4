<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Utilisateur::class, function(Faker $faker) {
	return [
		"nom"      => $faker->firstName,
		"prenom"   => $faker->lastName,
		"email"    => $faker->safeEmail,
		"password" => \Illuminate\Support\Facades\Hash::make($faker->password),

		"academie_id" => 1,
		"service_id"  => 1,
	];
});
