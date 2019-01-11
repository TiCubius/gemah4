<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionServiceTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions_services', function(Blueprint $table) {
			$table->primary(['service_id', 'permission_id']);

			$table->unsignedInteger('service_id');
			$table->unsignedInteger('permission_id');

			$table->foreign('service_id')->references('id')->on('services');
			$table->foreign('permission_id')->references('id')->on('permissions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('permission_service');
	}
}
