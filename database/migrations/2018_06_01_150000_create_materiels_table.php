<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterielsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('materiels', function (Blueprint $table) {
			$table->increments('id');

			$table->string('departement_id');
			$table->unsignedInteger('etat_administratif_materiel_id');
            $table->unsignedInteger('etat_physique_materiel_id');
			$table->unsignedInteger('eleve_id')->nullable();
			$table->unsignedInteger('type_materiel_id');
			$table->string('numero_serie')->nullable();
			$table->string('cle_produit')->nullable();
			$table->string('marque');
			$table->string('modele');
			$table->float('prix_ttc')->nullable();
			$table->string('nom_fournisseur')->nullable();
			$table->string('numero_devis')->nullable();
			$table->string('numero_formulaire_chorus')->nullable();
			$table->string('numero_facture_chorus')->nullable();
			$table->string('numero_ej')->nullable();
			$table->date('date_ej')->nullable();
			$table->date('date_facture')->nullable();
			$table->date('date_service_fait')->nullable();
			$table->date('date_fin_garantie')->nullable();
			$table->date('date_pret')->nullable();
			$table->string('achat_pour')->nullable();

			$table->foreign('departement_id')->references('id')->on('departements');
			$table->foreign('etat_administratif_materiel_id')->references('id')->on('etats_administratifs_materiels');
            $table->foreign('etat_physique_materiel_id')->references('id')->on('etats_physiques_materiels');
			$table->foreign('eleve_id')->references('id')->on('eleves');
			$table->foreign('type_materiel_id')->references('id')->on('types_materiels');

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
