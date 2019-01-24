<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materiel extends Model
{
	/**
	 * Liste des attributs pouvant être converti par Carbon
	 *
	 * @var array
	 */
	protected $dates = [
		"date_ej",
		"date_pret",
		"date_facture",
		"date_service_fait",
		"date_fin_garantie",
	];

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"domaine_id",
		"eleve_id",
		"type_materiel_id",
		"departement_id",
		"marque",
		"modele",
		"numero_serie",
		"cle_produit",
		"nom_fournisseur",
		"prix_ttc",
		"etat_administratif_materiel_id",
		"etat_physique_materiel_id",
		"numero_devis",
		"numero_formulaire_chorus",
		"numero_facture_chorus",
		"numero_ej",
		"date_ej",
		"date_facture",
		"date_pret",
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
	 * Un matériel possède un état administratif
	 *
	 * @return BelongsTo
	 */
	public function etatAdministratif(): BelongsTo
	{
		return $this->belongsTo(EtatAdministratifMateriel::class, "etat_administratif_materiel_id");
	}

	/**
	 * Un matériel possède un état physique
	 *
	 * @return BelongsTo
	 */
	public function etatPhysique(): BelongsTo
	{
		return $this->belongsTo(EtatPhysiqueMateriel::class, "etat_physique_materiel_id");
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de création décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestCreated($query): Builder
	{
		return $query->orderBy("created_at", "DESC")->with("etatAdministratif", "etatPhysique");
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de mise à jours décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestUpdated($query): Builder
	{
		return $query->orderBy("updated_at", "DESC")->with("etatAdministratif", "etatPhysique");
	}

	/**
	 * Effectue une recherce sur le matériel
	 *
	 * @param             $query
	 * @param string|null $departementId
	 * @param int|null    $typeId
	 * @param int|null    $etatAdministratifId
	 * @param int|null    $etatPhysiqueId
	 * @param string|null $marque
	 * @param string|null $modele
	 * @param string|null $numeroSerie
	 * @param string|null $cleProduit
	 * @return Builder
	 */
	public function scopeSearch($query, ?string $departementId, ?int $typeId, ?int $etatAdministratifId, ?int $etatPhysiqueId, ?string $marque, ?string $modele, ?string $numeroSerie, ?string $cleProduit): Builder
	{
		// On souhaite une requête SQL du type:
		// SELECT * FROM Materiels WHERE (type LIKE "%--%" OR marque LIKE "%--%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires

		$search = $query->select('materiels.*')->where(function ($query) use ($typeId, $marque, $modele, $numeroSerie, $cleProduit) {
			if ($marque) {
				$query = $query->orWhere("marque", "LIKE", "%{$marque}%");
			}
			if ($modele) {
				$query = $query->orWhere("modele", "LIKE", "%{$modele}%");
			}
			if ($numeroSerie) {
				$query = $query->orWhere("numero_serie", "LIKE", "%{$numeroSerie}%");
			}
			if ($cleProduit) {
				$query = $query->orWhere("numero_serie", "LIKE", "%{$cleProduit}%");
			}
		});

		if ($departementId) {
			$search = $search->where("departement_id", $departementId);
		}

		if ($typeId) {
			$search = $search->where("type_materiel_id", $typeId);
		}

		if ($etatAdministratifId) {
			$search = $search->where("etat_administratif_materiel_id", $etatAdministratifId);
		}

		if ($etatPhysiqueId) {
			$search = $search->where("etat_physique_materiel_id", $etatPhysiqueId);
		}

		return $search;
	}
}
