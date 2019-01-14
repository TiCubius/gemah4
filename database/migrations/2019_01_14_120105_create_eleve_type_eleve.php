<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEleveTypeEleve extends Migration
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
