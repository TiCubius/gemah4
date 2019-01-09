<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documents', function(Blueprint $table) {
			$table->increments('id');

			$table->string('nom')->nullable();
			$table->unsignedInteger('type_document_id');
			$table->string('description')->nullable();
			$table->string('path')->nullable();

			$table->unsignedInteger('eleve_id');
			$table->foreign('eleve_id')->references('id')->on('eleves');
            $table->foreign('type_document_id')->references('id')->on('types_document');

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
		Schema::dropIfExists('documents');
	}
}
