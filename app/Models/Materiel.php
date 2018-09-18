<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materiel extends Model
{
	protected $fillable = [
		"domaine_id",
		"type_id",
		"marque",
		"modele",
		"num_serie",
		"nom_fournisseur",
		"prix_ttc",
		"etat_id",
		"num_devis",
		"num_formulaire_chorus",
		"num_facture_chorus",
		"num_ej",
		"date_ej",
		"date_facture",
		"date_service_fait",
		"date_fin_garantie",
		"acheter_pour",
	];

	/**
	 * Un matériel appartient à un type de matériel
	 *
	 * @return BelongsTo
	 */
	public function Type(): BelongsTo
	{
		return $this->belongsTo(TypeMateriel::class);
	}

}
