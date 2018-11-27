<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Utilisateur::class, function(Faker $faker) {
	$academy = factory(\App\Models\Academie::class)->create();
	$service = factory(\App\Models\Service::class)->create();

	return [
		"nom"      => $faker->word,
		"prenom"   => $faker->word,
		"email"    => $faker->safeEmail,
		"password" => \Illuminate\Support\Facades\Hash::make($faker->password),

		"academie_id" => $academy->id,
		"service_id"  => $service->id,
	];
});
