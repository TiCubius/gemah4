<?php

namespace App\Models;

use App\Observers\DomaineMaterielObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DomaineMateriel extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	public $table = "domaines_materiels";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"libelle",
	];

	protected $dispatchesEvents = [
		"created" => DomaineMaterielObserver::class,
		"updated" => DomaineMaterielObserver::class,
		"deleted" => DomaineMaterielObserver::class,
	];


	/**
	 * Un domaine matériel possède plusieurs types de matériel
	 *
	 * @return HasMany
	 */
	public function types(): HasMany
	{
		return $this->hasMany(TypeMateriel::class, 'domaine_id')->orderby("libelle");
	}
}
