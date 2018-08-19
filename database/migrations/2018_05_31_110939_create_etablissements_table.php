<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtablissementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->string('id');

	        $table->unsignedInteger('enseignant_id');
	        $table->unsignedInteger('academie_id');
            $table->string('type');
            $table->string('nom');
	        $table->string('degre');
	        $table->string('regime');
	        $table->string('adresse');
	        $table->string('code_postal');
	        $table->string('ville');
	        $table->string('telephone');


			$table->primary('id');
	        $table->foreign('enseignant_id')->references('id')->on('enseignants');
	        $table->foreign('academie_id')->references('id')->on('academies');
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
        Schema::dropIfExists('etablissements');
    }
}
