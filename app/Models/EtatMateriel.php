<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EtatMateriel extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	public $table = "etats_materiels";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"libelle",
		"couleur",
	];


	/**
	 * Un état de matériels possède plusieurs matériels
	 *
	 * @return HasMany
	 */
	public function materiels(): HasMany
	{
		return $this->hasMany(Materiel::class, "etat_materiel_id");
	}
}
