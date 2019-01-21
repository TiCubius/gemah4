<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeMateriel extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	public $table = "types_materiels";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"libelle",
		"domaine_id",
	];


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
	 * Un type de matériel possède plusieurs matériels
	 *
	 * @return HasMany
	 */
	public function materiels(): HasMany
	{
		return $this->hasMany(Materiel::class);
	}
}
