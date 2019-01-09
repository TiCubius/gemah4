<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $dates = [
        "date_cda",
        "date_notif",
        "date_limite",
        "date_convention",
    ];

    /***
     * Une decision appartient à un élève
     *
     * @return BelongsTo
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /***
     * Une decision est liée a un enseignant
     *
     * @return BelongsTo
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    /***
     * Une decision possède un document
     *
     * @return BelongsTo
     */
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
