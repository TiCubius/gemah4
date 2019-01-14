<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TypeEleve extends Model
{
    protected $table = "types_eleves";
    protected $fillable = ["nom"];

    /**
     * Un type d'élève appartient à plusieurs élève
     *
     * @return BelongsToMany
     */
    public function eleves() : BelongsToMany{
        return $this->belongsToMany(Eleve::class);
    }
}
