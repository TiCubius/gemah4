<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parametres', function (Blueprint $table) {
			$table->string('departement_id');
			$table->string('libelle');
			$table->string('key');
			$table->string('value')->nullable();

			$table->primary(["departement_id", "key"]);
			$table->foreign("departement_id")->references("id")->on("departements");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('parametres');
	}
}
