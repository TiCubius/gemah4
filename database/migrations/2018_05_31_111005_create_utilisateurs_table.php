<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('academie_id');
            $table->unsignedInteger('service_id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('password');
//            $table->boolean('reception_email');

            $table->foreign('academie_id')->references('id')->on('academies');
            $table->foreign('service_id')->references('id')->on('services');

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
        Schema::dropIfExists('utilisateurs');
    }
}
