<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnseignantsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enseignants', function(Blueprint $table) {
			$table->increments('id');

			$table->enum('civilite', ['M', 'Mme']);
			$table->string('nom');
			$table->string('prenom');
			$table->string('email');
			$table->string('telephone')->nullable();

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
