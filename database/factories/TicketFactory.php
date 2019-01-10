<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Ticket::class, function(Faker $faker) {
	$type_ticket = factory(\App\Models\TypeTicket::class)->create();
	$eleve = factory(\App\Models\Eleve::class)->create();

	return [
		"type_ticket_id" => $type_ticket->id,
		"eleve_id"       => $eleve->id,

		"libelle" => $faker->sentence,
	];
});
