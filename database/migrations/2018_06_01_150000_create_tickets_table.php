<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('type_ticket_id');
			$table->unsignedInteger('eleve_id');
			$table->string("libelle");
			$table->boolean("utilisation_joker")->default(false);

			$table->foreign('type_ticket_id')->references('id')->on('types_tickets');
			$table->foreign('eleve_id')->references('id')->on('eleves');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('tickets');
	}
}
