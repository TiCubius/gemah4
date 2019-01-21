<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
    protected $fillable = [
        "nom",
        "type_document_id",
        "description",
        "path",
        "eleve_id"
    ];


    /**
     * Un document possède une décision
     *
     * @return HasOne
     */
    public function decision(): HasOne
    {
        return $this->hasOne(Decision::class);
    }

    /***
     * Un document appartient à un élève
     *
     * @return BelongsTo
     */
    public function eleve(): BelongsTo
    {
        return $this->BelongsTo(Eleve::class);
    }

    /**
     * Un document appartient à un type de document
     *
     * @return BelongsTo
     */
    public function typeDocument(): BelongsTo
    {
        return $this->BelongsTo(TypeDocument::class, "type_document_id");
    }
}
