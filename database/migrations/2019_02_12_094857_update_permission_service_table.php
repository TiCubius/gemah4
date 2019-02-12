<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePermissionServiceTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (env("DB_CONNECTION") !== "sqlite") {
			Schema::table('permission_service', function (Blueprint $table) {
				$table->dropForeign(["service_id"]);
				$table->dropForeign(["permission_id"]);
				$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
				$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
			});
		}

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}
