<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

	/**
	 * @return BelongsTo
	 */
	public function Etat(): BelongsTo
	{
		return $this->belongsTo(EtatMateriel::class);
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de création décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopelatestCreated($query): Builder
	{
		return $query->orderBy("created_at", "DESC");
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de mise à jours décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopelatestUpdated($query): Builder
	{
		return $query->orderBy("updated_at", "DESC");
	}

	/**
	 * Effectue une recherce sur le matériel
	 *
	 * @param        $query
	 * @param        $typeId
	 * @param        $marque
	 * @param        $modele
	 * @param        $numSerie
	 * @return Builder
	 */
	public function scopeSearch($query, $typeId, $marque, $modele, $numSerie): Builder
	{
		// Dans le cas où la variable "type", "marque", "num_serie" est vide, on souhaite ignorer le champs
		// dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
		$typeId = $typeId ?? "--";
		$marque = $marque ?? "--";
		$modele = $modele ?? "--";
		$numSerie = $numSerie ?? "--";

		// On souhaite une requête SQL du type:
		// SELECT * FROM Materiels WHERE (type LIKE "%--%" OR marque LIKE "%--%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		return $query->where(function($query) use ($typeId, $marque, $modele, $numSerie) {
			$query->where("type_id", "=", $typeId)->orWhere("marque", "LIKE", "%{$marque}%")->orWhere("modele", "LIKE", "%{$modele}%")->orWhere("num_serie", "LIKE", "%{$numSerie}%");
		});
	}

}