<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	/**
	 * La clé primaire n'est pas un autoincrement
	 *
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * La table ne dispose pas des atributs "created_at" et "updated_at"
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"id",
		"libelle",
	];

}
