<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EtatAdministratifMateriel extends Model
{
	public $table = "etats_administratifs_materiels";
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
		return $this->hasMany(Materiel::class, "etat_administratif_materiel_id");
	}
}
