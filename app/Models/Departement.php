<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
	/**
	 * La clé primaire n'est pas un autoincrement
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"id",
		"nom",
		"academie_id",
	];

	/**
	 * Un département appartient à une academie
	 *
	 * @return belongsTo
	 */
	public function academie(): belongsTo
	{
		return $this->belongsTo(Academie::class);
	}

	/***
	 * Un département possède plusieurs élèves
	 *
	 * @return hasMany
	 */
	public function eleves(): hasMany
	{
		return $this->hasMany(Eleve::class);
	}

	/***
	 * Un département possède plusieurs établissements
	 *
	 * @return hasMany
	 */
	public function etablissements(): hasMany
	{
		return $this->hasMany(Etablissement::class);
	}

	/***
	 * Un département possède plusieurs matériels
	 *
	 * @return hasMany
	 */
	public function materiels(): hasMany
	{
		return $this->hasMany(Materiel::class);
	}

	/***
	 * Un département possède plusieurs responsables
	 *
	 * @return hasMany
	 */
	public function responsables(): hasMany
	{
		return $this->hasMany(Responsable::class);
	}

	/***
	 * Un département possède plusieurs services
	 *
	 * @return hasMany
	 */
	public function services(): hasMany
	{
		return $this->hasMany(Service::class);
	}
}
