<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Decision extends Model
{
	/**
	 * Liste des attributs pouvant être converti par Carbon
	 *
	 * @var array
	 */
	protected $dates = [
		"date_cda",
		"date_notification",
		"date_limite",
		"date_convention",
	];

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"document_id",
		"enseignant_id",
		"date_cda",
		"date_notification",
		"date_limite",
		"date_convention",
		"numero_dossier",
	];


	/***
	 * Une décision est liée a un document
	 *
	 * @return BelongsTo
	 */
	public function document(): BelongsTo
	{
		return $this->belongsTo(Document::class);
	}

	/***
	 * Une décision est liée a un enseignant
	 *
	 * @return BelongsTo
	 */
	public function enseignant(): BelongsTo
	{
		return $this->belongsTo(Enseignant::class);
	}

	/**
	 * Une décision apprtient à plusieurs types
	 *
	 * @return BelongsToMany
	 */
	public function types(): BelongsToMany
	{
		return $this->belongsToMany(TypeDecision::class);
	}
}
