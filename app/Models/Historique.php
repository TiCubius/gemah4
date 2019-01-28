<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $fillable = [
        "from_id",

        "region_id",
        "academie_id",
        "departement_id",

        "responsable_id",
        "enseignant_id",
        "etablissement_id",
        "type_etablissement_id",
        "eleve_id",
        "type_eleve_id",

        "ticket_id",
        "message_ticket_id",
        "type_ticket_id",

        "decision_id",
        "document_id",
        "type_document_id",

        "domaine_id",
        "etat_administratif_materiel_id",
        "etat_physique_materiel_id",
        "materiel_id",
        "type_materiel_id",

        "service_id",
        "utilisateur_id",

        "type",
        "contenue",
    ];
}
