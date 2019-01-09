<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEleveResponsableTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eleve_responsable', function(Blueprint $table) {
			$table->primary(['eleve_id', 'responsable_id']);

			$table->unsignedInteger('eleve_id');
			$table->unsignedInteger('responsable_id');

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
