<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materiel extends Model
{
	protected $fillable = [
		"domaine_id",
		"eleve_id",
		"type_materiel_id",
        "departement_id",
		"marque",
		"modele",
		"numero_serie",
		"nom_fournisseur",
		"prix_ttc",
		"etat_materiel_id",
		"numero_devis",
		"numero_formulaire_chorus",
		"numero_facture_chorus",
		"numero_ej",
		"date_ej",
		"date_facture",
		"date_service_fait",
		"date_fin_garantie",
		"acheter_pour",
	];

	/**
	 * Un matériel appartient à un élève
	 *
	 * @return BelongsTo
	 */
	public function eleve(): BelongsTo
	{
		return $this->belongsTo(Eleve::class);
	}

	/**
	 * Un matériel appartient à un type de matériel
	 *
	 * @return BelongsTo
	 */
	public function type(): BelongsTo
	{
		return $this->belongsTo(TypeMateriel::class, "type_materiel_id");
	}

	/**
     * Un matériel possède un état
     *
	 * @return BelongsTo
	 */
	public function etat(): BelongsTo
	{
		return $this->belongsTo(EtatMateriel::class, "etat_materiel_id");
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de création décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestCreated($query): Builder
	{
		return $query->orderBy("created_at", "DESC")->with("etat");
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de mise à jours décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestUpdated($query): Builder
	{
		return $query->orderBy("updated_at", "DESC")->with("etat");
	}

    /**
     * Effectue une recherce sur le matériel
     *
     * @param        $query
     * @param        $typeId
     * @param        $etatId
     * @param        $marque
     * @param        $modele
     * @param        $numeroSerie
     * @return Builder
     */
	public function scopeSearch($query, $typeId, $etatId, $marque, $modele, $numeroSerie): Builder
	{
		// Dans le cas où la variable "type", "marque", "numero_serie" est vide, on souhaite ignorer le champs
		// dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
		$typeId = $typeId ?? "--";
		$etatId = $etatId ?? "--";
		$marque = $marque ?? "--";
		$modele = $modele ?? "--";
		$numeroSerie = $numeroSerie ?? "--";

		// On souhaite une requête SQL du type:
		// SELECT * FROM Materiels WHERE (type LIKE "%--%" OR marque LIKE "%--%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		return $query->select('materiels.*')
			->join("etats_materiels", "materiels.etat_materiel_id", "etats_materiels.id")
			->where(function($query) use ($typeId, $marque, $modele, $numeroSerie) {
				$query->where("type_materiel_id", $typeId)
					->orWhere("marque", "LIKE", "%{$marque}%")
					->orWhere("modele", "LIKE", "%{$modele}%")
					->orWhere("numero_serie", "LIKE", "%{$numeroSerie}%");
			})
			->orWhere("etat_materiel_id", $etatId);
	}

}
