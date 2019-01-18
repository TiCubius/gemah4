<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeMateriel extends Model
{
	public $table = "types_materiels";
	protected $fillable = ["libelle", "domaine_id"];

	/**
	 * Un type appartient à un domaine
	 *
	 * @return BelongsTo
	 */
	public function domaine(): BelongsTo
	{
		return $this->belongsTo(DomaineMateriel::class)->orderBy("libelle");
	}

	/**
	 * Un type possède plusieurs matériels
	 *
	 * @return HasMany
	 */
	public function materiels(): HasMany
	{
		return $this->hasMany(Materiel::class);
	}
}
