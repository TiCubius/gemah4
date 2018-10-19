<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EtatMateriel extends Model
{
	public $table = "etats_materiel";
	protected $fillable = ["nom", "couleur"];

	/**
	 * @return HasMany
	 */
	public function materiels()
	{
		return $this->hasMany(Materiel::class, "etat_id");
	}
}
