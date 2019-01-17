<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EtatMateriel extends Model
{
	public $table = "etats_materiels";
	protected $fillable = [
	    "libelle",
        "couleur"
    ];

	/**
     * Un état de matériels est lié à plusieurs matériel
     *
	 * @return HasMany
	 */
	public function materiels()
	{
		return $this->hasMany(Materiel::class, "etat_materiel_id");
	}
}
