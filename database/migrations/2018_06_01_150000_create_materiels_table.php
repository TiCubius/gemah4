<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterielsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('materiels', function(Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('etat_id');
			$table->unsignedInteger('eleve_id')->nullable();
			$table->unsignedInteger('type_id');
			$table->string('num_serie')->nullable();
			$table->string('cle_produit')->nullable();
			$table->string('marque');
			$table->string('modele');
			$table->float('prix_TTC')->nullable();
			$table->string('nom_fournisseur')->nullable();
			$table->string('num_devis')->nullable();
			$table->string('num_formulaire_chorus')->nullable();
			$table->string('num_facture_chorus')->nullable();
			$table->string('num_EJ')->nullable();
			$table->string('acheter_pour')->nullable();
			$table->date('date_EJ')->nullable();
			$table->date('date_facture')->nullable();
			$table->date('date_service_fait')->nullable();
			$table->date('date_fin_garantie')->nullable();
			$table->date('date_pret')->nullable();

			$table->foreign('etat_id')->references('id')->on('etats_materiels');
			$table->foreign('eleve_id')->references('id')->on('eleves');
			$table->foreign('type_id')->references('id')->on('types_materiels');

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
		Schema::dropIfExists('materiels');
	}
}
