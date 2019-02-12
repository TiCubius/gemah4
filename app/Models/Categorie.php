<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
	protected $guarded = [];

	/**
	 * Le nom de la table n'est pas celui attendu
	 *
	 * @var string
	 */
	public $table = "categories";


	public function documentations(): HasMany
	{
		return $this->hasMany(Documentation::class, "categorie_id")->orderBy("libelle");
	}

	/**
	 * Une catégorie possède plusieurs sous-catégories
	 *
	 * @return HasMany
	 */
	public function enfants(): HasMany
	{
		return $this->hasMany(Categorie::class, "categorie_id")->with("enfants", "documentations")->orderBy("libelle");
	}

	/**
	 * Une catégorie appartient à un parent
	 *
	 * @return BelongsTo
	 */
	public function parent(): BelongsTo
	{
		return $this->belongsTo(Categorie::class, "categorie_id");
	}
}
