<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TypeMateriel extends Model
{
    public $table = "types_materiel";
    protected $fillable = ["nom", "domaine_id"];

	/**
	 * @return BelongsTo
	 */
    public function domaine(): BelongsTo
    {
    	return $this->belongsTo(DomaineMateriel::class);
    }
}
