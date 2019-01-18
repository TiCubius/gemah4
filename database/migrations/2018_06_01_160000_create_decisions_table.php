<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecisionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('decisions', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('document_id');
			$table->unsignedInteger('enseignant_id')->nullable();
			$table->timestamp('date_cda')->nullable();
			$table->timestamp('date_notification')->nullable();
			$table->timestamp('date_limite')->nullable();
			$table->timestamp('date_convention')->nullable();
			$table->integer('numero_dossier')->nullable();

			$table->foreign('document_id')->references('id')->on('documents');
			$table->foreign('enseignant_id')->references('id')->on('enseignants');
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
		Schema::dropIfExists('decisions');
	}
}
