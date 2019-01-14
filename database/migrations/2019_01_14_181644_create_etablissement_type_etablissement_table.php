<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtablissementTypeEtablissement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissement_type_etablissement', function (Blueprint $table) {
            $table->unsignedInteger('etablissement_id');
            $table->unsignedInteger('type_etablissement_id');

            $table->primary(["etablissement_id", "type_etablissement_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etablissement_type_etablissement');
    }
}
