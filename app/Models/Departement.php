<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Departement extends Model
{
    protected $fillable = [
        "id",
        "nom",
        "academie_id"
    ];


    /**
     * Un département dépend d'une Academie
     *
     * @return HasOne
     */
    public function academie(): HasOne
    {
        return $this->hasOne(Academie::class);
    }
}
