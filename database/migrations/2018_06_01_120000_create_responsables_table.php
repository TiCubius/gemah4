<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('responsables', function(Blueprint $table) {
			$table->increments('id');

			$table->enum('civilite', ['M', 'Mme', 'M/Mme']);
			$table->string('nom');
			$table->string('prenom');
			$table->string('email')->nullable();
			$table->string('telephone')->nullable();
			$table->string('code_postal')->nullable();
			$table->string('ville')->nullable();
            $table->string('adresse')->nullable();
            $table->string('departement_id');

            $table->foreign('departement_id')->references('id')->on('departements');

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
		Schema::dropIfExists('responsables');
	}
}
