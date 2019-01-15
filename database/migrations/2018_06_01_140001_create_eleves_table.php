<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElevesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eleves', function(Blueprint $table) {
			$table->increments('id');

			$table->string('etablissement_id')->nullable();
            $table->string('departement_id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('code_INE', 11)->nullable();
            $table->string('classe');
            $table->integer('joker')->default(0);
            $table->float('prix_global')->default(0);
            $table->date('date_naissance');
            $table->date('date_rendu_definitive')->nullable();

            $table->foreign('departement_id')->references('id')->on('departements');
			$table->foreign('etablissement_id')->references('id')->on('etablissements');

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
		Schema::dropIfExists('eleves');
	}
}
