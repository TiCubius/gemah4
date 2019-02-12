<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documentations', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger("categorie_id");

			$table->string("libelle");
			$table->text("contenu");

			$table->foreign("categorie_id")->references("id")->on("categories");

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
		Schema::dropIfExists('documentations');
	}
}
