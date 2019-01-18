<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Decision::class, function (Faker $faker) {
	$typeDocument = factory(\App\Models\TypeDocument::class)->create([
		"libelle" => "Décision",
	]);
	$document = factory(\App\Models\Document::class)->create([
		"type_document_id" => $typeDocument->id,
	]);
	$enseignant = factory(\App\Models\Enseignant::class)->create();

	return [
		"document_id"       => $document->id,
		"enseignant_id"     => $enseignant->id,
		"date_cda"          => $faker->dateTime,
		"date_notification" => $faker->dateTime,
		"date_limite"       => $faker->dateTime,
		"date_convention"   => $faker->dateTime,
		"numero_dossier"    => $faker->randomNumber(6, true),
	];
});
