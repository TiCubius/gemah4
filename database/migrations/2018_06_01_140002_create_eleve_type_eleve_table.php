<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEleveTypeEleveTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eleve_type_eleve', function (Blueprint $table) {
			$table->unsignedInteger('eleve_id');
			$table->unsignedInteger('type_eleve_id');

			$table->primary(["eleve_id", "type_eleve_id"]);

			$table->foreign("eleve_id")->references("id")->on("eleves");
			$table->foreign("type_eleve_id")->references("id")->on("types_eleves");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('eleve_type_eleve');
	}
}
