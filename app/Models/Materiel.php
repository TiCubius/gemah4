<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

	/**
	 * @return BelongsTo
	 */
	public function Etat(): BelongsTo
	{
		return $this->belongsTo(EtatMateriel::class);
	}


	/**
	 * Effectue une recherce sur le
	 *
	 * @param        $query
	 * @param        $type_id
	 * @param        $marque
	 * @param        $num_serie
	 * @return Builder
	 */
	public function scopeSearch($query, $type_id, $marque, $num_serie): Builder
	{
		// Dans le cas où la variable "type", "marque", "num_serie" est vide, on souhaite ignorer le champs
		// dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
		$type_id = $type_id ?? "--";
		$marque = $marque?? "--";
		$num_serie = $num_serie ?? "--";

		// On souhaite une requête SQL du type:
		// SELECT * FROM Materiels WHERE (type LIKE "%--%" OR marque LIKE "%--%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		return $query->where(function($query) use ($type_id, $marque, $num_serie) {
			$query->where("type_id", "=", $type_id)
				->orWhere("marque", "LIKE", "%{$marque}%")
				->orWhere("num_serie", "LIKE", "%{$num_serie}%");
		});
	}

}
