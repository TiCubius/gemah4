<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartementsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departements', function (Blueprint $table) {
			$table->string('id');
			$table->unsignedInteger('academie_id');
			$table->string('nom');

			$table->primary('id');

			$table->foreign('academie_id')->references('id')->on('academies');

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
		Schema::dropIfExists('departements');
	}
}
