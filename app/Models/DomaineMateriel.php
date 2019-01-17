<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DomaineMateriel extends Model
{
	public $table = "domaines_materiels";
	protected $fillable = [
	    "libelle"
    ];

	/**
	 * Un Domaine Matériel possède plusieurs types
	 *
	 * @return HasMany
	 */
	public function types(): HasMany
	{
		return $this->hasMany(TypeMateriel::class, 'domaine_id')->orderby("libelle");
	}
}
