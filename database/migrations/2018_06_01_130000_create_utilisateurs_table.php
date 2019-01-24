<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateursTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('utilisateurs', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('service_id');
			$table->string('nom');
			$table->string('prenom');
			$table->string('identifiant');
			$table->string('email');
			$table->string('password');
			//			$table->boolean('reception_email');

			$table->foreign('service_id')->references('id')->on('services');

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
		Schema::dropIfExists('utilisateurs');
	}
}
