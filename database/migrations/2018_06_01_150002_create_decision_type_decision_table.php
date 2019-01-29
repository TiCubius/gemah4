<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecisionTypeDecisionTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('decision_type_decision', function (Blueprint $table) {
			$table->unsignedInteger('decision_id');
			$table->unsignedInteger('type_decision_id');

			$table->primary(["decision_id", "type_decision_id"]);

			$table->foreign("decision_id")->references("id")->on("decisions");
			$table->foreign("type_decision_id")->references("id")->on("types_decisions");
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
