<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('type_id');
			$table->unsignedInteger('eleve_id');
			$table->string('description');

			$table->foreign('type_id')->references('id')->on('types_tickets');
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
