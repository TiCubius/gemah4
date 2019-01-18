<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnseignantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enseignants', function (Blueprint $table) {
			$table->increments('id');

			$table->enum('civilite', ['M.', 'Mme']);
			$table->string('nom');
			$table->string('prenom');
			$table->string('email')->nullable();
			$table->string('telephone')->nullable();
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
		Schema::dropIfExists('enseignants');
	}
}
