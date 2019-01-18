<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEleveResponsableTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eleve_responsable', function (Blueprint $table) {
			$table->primary(['eleve_id', 'responsable_id']);

			$table->unsignedInteger('eleve_id');
			$table->unsignedInteger('responsable_id');
			$table->boolean('etat_signature')->default(0);
			$table->timestamp('date_signature')->nullable();

			$table->foreign('eleve_id')->references('id')->on('eleves');
			$table->foreign('responsable_id')->references('id')->on('responsables');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('eleve_responsable');
	}
}
