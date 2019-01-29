<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        "type_ticket_id",

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

    /***
     *  Afin d'accéder au ressources possiblement présente dans l'historique et ne pas surchargé de requête,
     *  un lien direct vers chaque ressources possiblement concerné doit être défini.
     */

    /**
     * L'historique est lié à un utilisateur ayant effecté l'action
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, "from_id");
    }

    /**
     * L'historique est possiblement lié à une région
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * L'historique est possiblement lié à une académie
     *
     * @return BelongsTo
     */
    public function academie(): BelongsTo
    {
        return $this->belongsTo(Academie::class);
    }

    /**
     * L'historique est possiblement lié à un département
     *
     * @return BelongsTo
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * L'historique est possiblement lié à un responsable
     *
     * @return BelongsTo
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Responsable::class);
    }

    /**
     * L'historique est possiblement lié à un enseignant
     *
     * @return BelongsTo
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    /**
     * L'historique est possiblement lié à un établissement
     *
     * @return BelongsTo
     */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    /**
     * L'historique est possiblement lié à un type d'établissement
     *
     * @return BelongsTo
     */
    public function typeEtablissement(): BelongsTo
    {
        return $this->belongsTo(TypeEtablissement::class);
    }

    /**
     * L'historique est possiblement lié à un élève
     *
     * @return BelongsTo
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /**
     * L'historique est possiblement lié à un type d'élève
     *
     * @return BelongsTo
     */
    public function typeEleve(): BelongsTo
    {
        return $this->belongsTo(TypeEleve::class);
    }

    /**
     * L'historique est possiblement lié à un ticket
     *
     * @return BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * L'historique est possiblement lié à un type de ticket
     *
     * @return BelongsTo
     */
    public function typeTicket(): BelongsTo
    {
        return $this->belongsTo(TypeTicket::class);
    }

    /**
     * L'historique est possiblement lié à un document
     *
     * @return BelongsTo
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    /**
     * L'historique est possiblement lié à un type de document
     *
     * @return BelongsTo
     */
    public function typeDocument(): BelongsTo
    {
        return $this->belongsTo(TypeDocument::class);
    }

    /**
     * L'historique est possiblement lié à un domaine de matériel
     *
     * @return BelongsTo
     */
    public function domaineMateriel(): BelongsTo
    {
        return $this->belongsTo(DomaineMateriel::class, "domaine_id");
    }

    /**
     * L'historique est possiblement lié à un état administratif de matériel
     *
     * @return BelongsTo
     */
    public function etatAdministratifMateriel(): BelongsTo
    {
        return $this->belongsTo(EtatAdministratifMateriel::class);
    }

    /**
     * L'historique est possiblement lié à un état physique matériel
     *
     * @return BelongsTo
     */
    public function etatPhysiqueMateriel(): BelongsTo
    {
        return $this->belongsTo(EtatPhysiqueMateriel::class);
    }

    /**
     * L'historique est possiblement lié à un matériel
     *
     * @return BelongsTo
     */
    public function materiel(): BelongsTo
    {
        return $this->belongsTo(Materiel::class);
    }

    /**
     * L'historique est possiblement lié à un type de matériel
     *
     * @return BelongsTo
     */
    public function typeMateriel(): BelongsTo
    {
        return $this->belongsTo(TypeMateriel::class);
    }

    /**
     * L'historique est possiblement lié à un service
     *
     * @return BelongsTo
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * L'historique est possiblement lié à un utilisateur
     *
     * @return BelongsTo
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
