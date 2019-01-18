<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesMaterielsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('types_materiels', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('domaine_id');
			$table->string('libelle');

			$table->foreign('domaine_id')->references('id')->on('domaines_materiels');
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
		Schema::dropIfExists('types_materiels');
	}
}
