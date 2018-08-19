<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDecisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decisions', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date_cda')->nullable();
            $table->date('date_notif')->nullable();
            $table->date('date_limite');
            $table->date('date_convention')->nullable();
			$table->integer('numero_dossier')->nullable();
            $table->string('nom_suivi')->nullable();
	        $table->unsignedInteger('eleve_id');
			$table->unsignedInteger('document_id')->nullable();
			$table->unsignedInteger('enseignant_id')->nullable();

	        $table->foreign('eleve_id')->references('id')->on('eleves');
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');
			$table->foreign('enseignant_id')->references('id')->on('enseignants');

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
        Schema::dropIfExists('decisions');
    }
}
