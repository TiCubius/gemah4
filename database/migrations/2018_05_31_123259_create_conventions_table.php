<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conventions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('eleve_id');
            $table->unsignedInteger('responsable_id');
            $table->boolean('etat_signature');

            $table->foreign('eleve_id')->references('id')->on('eleves');
            $table->foreign('responsable_id')->references('id')->on('responsables');

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
        Schema::dropIfExists('conventions');
    }
}
