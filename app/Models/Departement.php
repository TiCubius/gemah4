<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Departement extends Model
{
    public $incrementing = false;
    protected $fillable = [
        "id",
        "nom",
        "academie_id"
    ];


    /**
     * Un département dépend d'une Academie
     *
     * @return belongsTo
     */
    public function academie(): belongsTo
    {
        return $this->belongsTo(Academie::class);
    }
}
