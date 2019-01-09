<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    protected $fillable = [
        "eleve_id",
        "document_id",
        "enseignant_id",
        "date_cda",
        "date_notif",
        "date_limite",
        "date_convention",
        "numero_dossier",
        "nom_suivi",
    ];

    /***
     * Un Document appartient à un élève
     *
     * @return BelongsTo
     */
    public function eleve(): BelongsTo
    {
        return $this->BelongsTo(Eleve::class);
    }
}
