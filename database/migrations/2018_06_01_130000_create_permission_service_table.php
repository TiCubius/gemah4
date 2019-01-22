<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionServiceTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_service', function (Blueprint $table) {
			$table->unsignedInteger('service_id');
			$table->string('permission_id');

			$table->primary(['service_id', 'permission_id']);
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
