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
			$table->increments('id');

			$table->unsignedInteger('eleve_id');
			$table->unsignedInteger('responsable_id');

			$table->foreign('eleve_id')->references('id')->on('eleves');
			$table->foreign('responsable_id')->references('id')->on('responsables');
			$table->unique(['id', 'eleve_id']);
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
		Schema::dropIfExists('responsables_eleves');
	}
}
