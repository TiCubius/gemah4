<?php

use App\Models\Ticket;
use Faker\Generator as Faker;

$factory->define(\App\Models\TicketMessage::class, function (Faker $faker) {
	$ticket = factory(Ticket::class)->create();

	return [
		"ticket_id" => $ticket->id,
		"contenu"   => $faker->text(800),
	];
});
