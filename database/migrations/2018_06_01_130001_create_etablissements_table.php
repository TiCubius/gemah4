<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtablissementsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('etablissements', function (Blueprint $table) {
			$table->string('id');

			$table->unsignedInteger('enseignant_id')->nullable();
			$table->unsignedInteger('type_etablissement_id');
			$table->string('departement_id');
			$table->string('nom');
			$table->string('degre')->nullable();
			$table->string('regime')->nullable();
			$table->string('adresse')->nullable();
			$table->string('code_postal')->nullable();
			$table->string('ville');
			$table->string('telephone')->nullable();

			$table->primary('id');
			$table->foreign('enseignant_id')->references('id')->on('enseignants');
			$table->foreign('type_etablissement_id')->references('id')->on('types_etablissements');
			$table->foreign('departement_id')->references('id')->on('departements')->onUpdate('cascade');
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
		Schema::dropIfExists('etablissements');
	}
}
