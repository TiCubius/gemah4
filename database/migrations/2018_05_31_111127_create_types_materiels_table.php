<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('nom');

            $table->foreign('domaine_id')->references('id')->on('domaines');

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
