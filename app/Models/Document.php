<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
    protected $fillable = [
        "nom",
        "type_document_id",
        "description",
        "path",
        "eleve_id"
    ];

    /***
     * Un document possède une décision
     *
     * @return HasOne
     */
    public function decision(): HasOne
    {
        return $this->hasOne(Decision::class);
    }

    /***
     * Un Document appartient à un élève
     *
     * @return BelongsTo
     */
    public function eleve(): BelongsTo
    {
        return $this->BelongsTo(Eleve::class);
    }

    /**
     * Un document est lié a un type de document
     *
     * @return BelongsTo
     */
    public function typeDocument(): BelongsTo
    {
        return $this->BelongsTo(TypeDocument::class, "type_document_id");
    }
}
