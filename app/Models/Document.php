<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Un Document appartient à un élève
     *
     * @return BelongsTo
     */
    public function eleve(): BelongsTo
    {
        return $this->BelongsTo(Eleve::class);
    }

    public function typeDocument(): BelongsTo
    {
        return $this->BelongsTo(TypeDocument::class);
    }
}
