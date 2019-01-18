<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriquesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historiques', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('from_id')->nullable();
			$table->unsignedInteger('academie_id')->nullable();
			$table->unsignedInteger('permission_id')->nullable();
			$table->unsignedInteger('service_id')->nullable();
			$table->unsignedInteger('utilisateur_id')->nullable();
			$table->unsignedInteger('enseignant_id')->nullable();
			$table->unsignedInteger('responsable_id')->nullable();
			$table->unsignedInteger('etat_materiel_id')->nullable();
			$table->unsignedInteger('domaine_id')->nullable();
			$table->unsignedInteger('type_ticket_id')->nullable();
			$table->string('etablissement_id')->nullable();
			$table->unsignedInteger('eleve_id')->nullable();
			$table->unsignedInteger('ticket_id')->nullable();
			$table->unsignedInteger('type_materiel_id')->nullable();
			$table->unsignedInteger('materiel_id')->nullable();
			$table->unsignedInteger('document_id')->nullable();
			$table->unsignedInteger('decision_id')->nullable();
			$table->unsignedInteger('message_ticket_id')->nullable();
			$table->string('type');
			$table->string('contenue');

			$table->foreign('from_id')->references('id')->on('utilisateurs')->onDelete('set null');
			$table->foreign('academie_id')->references('id')->on('academies')->onDelete('set null');
			$table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('set null');
			$table->foreign('decision_id')->references('id')->on('decisions')->onDelete('set null');
			$table->foreign('materiel_id')->references('id')->on('materiels')->onDelete('set null');
			$table->foreign('etat_materiel_id')->references('id')->on('etats_materiels')->onDelete('set null');
			$table->foreign('type_materiel_id')->references('id')->on('types_materiels')->onDelete('set null');
			$table->foreign('type_ticket_id')->references('id')->on('types_tickets')->onDelete('set null');
			$table->foreign('domaine_id')->references('id')->on('domaines_materiels')->onDelete('set null');
			$table->foreign('eleve_id')->references('id')->on('eleves')->onDelete('set null');
			$table->foreign('responsable_id')->references('id')->on('responsables')->onDelete('set null');
			$table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('set null');
			$table->foreign('enseignant_id')->references('id')->on('enseignants')->onDelete('set null');
			$table->foreign('utilisateur_id')->references('id')->on('utilisateurs')->onDelete('set null');
			$table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
			$table->foreign('document_id')->references('id')->on('documents')->onDelete('set null');
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('set null');
			$table->foreign('message_ticket_id')->references('id')->on('messages_tickets')->onDelete('set null');
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
		Schema::dropIfExists('historiques');
	}
}
