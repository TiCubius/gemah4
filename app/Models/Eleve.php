<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

class Eleve extends Model
{
	/**
	 * Liste des attributs pouvant être converti par Carbon
	 *
	 * @var array
	 */
	protected $dates = [
		"date_naissance",
	];

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"etablissement_id", "departement_id", "nom", "prenom", "code_ine", "classe", "joker", "prix_global", "date_naissance", "date_rendu_definitive",
	];


	/***
	 * Un élève peut avoir plusieurs décisions
	 *
	 * @return HasManyThrough
	 */
	public function decisions(): HasManyThrough
	{
		return $this->hasManyThrough(Decision::class, Document::class);
	}

	/***
	 * Un élève peut avoir plusieurs documents
	 *
	 * @return HasMany
	 */
	public function documents(): HasMany
	{
		return $this->hasMany(Document::class);
	}

	/***
	 * Un élève appartient à un établissement
	 *
	 * @return BelongsTo
	 */
	public function etablissement(): BelongsTo
	{
		return $this->belongsTo(Etablissement::class);
	}

	/***
	 * Un élève peut avoir plusieurs matériels
	 *
	 * @return HasMany
	 */
	public function materiels(): HasMany
	{
		return $this->hasMany(Materiel::class);
	}

	/***
	 * Un élève appartient à plusieurs responsables
	 * [Utilisation d'une table PIVOT]
	 *
	 * @return BelongsToMany
	 */
	public function responsables(): BelongsToMany
	{
		return $this->belongsToMany(Responsable::class)->withPivot('etat_signature', 'date_signature');
	}

	/**
	 * Un élève appartient à plusieurs types
	 * [Utilisation d'une table PIVOT]
	 *
	 * @return Collection
	 */
	public function getTypesAttribute(): Collection
	{
		$types = collect();
		$decisions = $this->decisions()->with("types")->get();

		foreach ($decisions as $decision) {
			foreach ($decision->types as $type) {
				$types->push($type);
			}
		}

		return $types->unique("id")->sortBy("libelle");
	}


	/**
	 * Retourne un Query Builder triant les résultats par date de création décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestCreated($query): Builder
	{
		return $query->orderBy("created_at", "DESC");
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de mise à jours décroissante
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestUpdated($query): Builder
	{
		return $query->orderBy("updated_at", "DESC");
	}


	/**
	 * Retourne un Query Builder avec uniquement les élèves ayant/n'ayant pas des documents
	 *
	 * @param $query
	 * @param $state
	 * @return Builder
	 */
	public function scopeHaveDocuments($query, $state): Builder
	{
		if ($state) {
			return $query->has("documents");
		} elseif (!$state) {
			return $query->doesntHave("documents");
		}
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de création des documents
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestDocumentCreated($query, $state): Builder
	{
		$query = $query->join("documents", "eleves.id", "=", "documents.eleve_id");

		if ($state) {
			return $query->orderBy("documents.created_at", "ASC");
		} elseif (!$state) {
			return $query->orderBy("documents.created_at", "DESC");
		}
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de mise à jours des documents
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestDocumentModified($query, $state): Builder
	{
		$query = $query->join("documents", "eleves.id", "=", "documents.eleve_id");

		if ($state) {
			return $query->orderBy("documents.updated_at", "ASC");
		} elseif (!$state) {
			return $query->orderBy("documents.updated_at", "DESC");
		}
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de création des tickets
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestTicketCreated($query, $state): Builder
	{
		$query = $query->join("tickets", "eleve.id", "=", "tickets.eleve_id");

		if ($state) {
			return $query->orderBy("tickets.created_at", "ASC");
		} elseif (!$state) {
			return $query->orderBy("tickets.created_at", "DESC");
		}
	}

	/**
	 * Retourne un Query Builder triant les résultats par date de mise à jours des tickets
	 *
	 * @param $query
	 * @return Builder
	 */
	public function scopeLatestTicketModified($query, $state): Builder
	{
		$query = $query->join("tickets", "eleve.id", "=", "tickets.eleve_id");

		if ($state) {
			return $query->orderBy("tickets.updated_at", "ASC");
		} elseif (!$state) {
			return $query->orderBy("tickets.updated_at", "DESC");
		}
	}

	/**
	 * Retourne un Query Builder avec uniquement les élèves ayant/n'ayant pas du matériels
	 *
	 * @param $query
	 * @param $state
	 * @return Builder
	 */
	public function scopeHaveMateriels($query, $state): Builder
	{
		if ($state) {
			return $query->has("materiels");
		} elseif (!$state) {
			return $query->doesntHave("materiels");
		}
	}

	/**
	 * Retourne un Query Builder avec uniquement les élèves ayant/n'ayant pas des responsables
	 *
	 * @param $query
	 * @param $state
	 * @return Builder
	 */
	public function scopeHaveResponsables($query, $state): Builder
	{
		if ($state) {
			return $query->has("responsables");
		} elseif (!$state) {
			return $query->doesntHave("responsables");
		}
	}

	/**
	 * Retourne un Query Builder avec uniquement les élèves étant/n'étant pas dans un établissement
	 *
	 * @param $query
	 * @param $state
	 * @return Builder
	 */
	public function scopeHaveEtablissement($query, $state): Builder
	{
		if ($state) {
			return $query->has("etablissement");
		} elseif (!$state) {
			return $query->doesntHave("etablissement");
		}
	}

	/**
	 * Effectue une recherce sur le département, type ET (nom, prénom, email ou téléphone sur élève)
	 *
	 * @param             $query
	 * @param string|null $departement_id
	 * @param string      $nom
	 * @param string      $prenom
	 * @param string|null $date_naissance
	 * @param string      $code_ine
	 * @param int|null    $eleve_id
	 * @return Builder
	 */
	public function scopeSearch($query, ?string $departement_id, ?string $nom, ?string $prenom, ?string $date_naissance, ?string $code_ine, ?int $eleve_id): Builder
	{
		// On souhaite une requête SQL du type:
		// SELECT * FROM eleves WHERE (nom LIKE "%$...%" OR prenom LIKE "%...%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		$search = $query->select("eleves.*")->where(function ($query) use ($nom, $prenom, $date_naissance, $code_ine) {
			if ($nom) {
				$query = $query->orWhere("nom", "LIKE", "%{$nom}%");
			}
			if ($prenom) {
				$query = $query->orWhere("prenom", "LIKE", "%{$prenom}%");
			}
			if ($date_naissance) {
				$query = $query->orWhere("date_naissance", "LIKE", "%{$date_naissance}%");
			}
			if ($code_ine) {
				$query = $query->orWhere("code_ine", "LIKE", "%{$code_ine}%");
			}
		});

		if ($departement_id) {
			$search->where("departement_id", $departement_id);
		}

		if ($eleve_id) {
			$search->where("id", "LIKE", "%" . $eleve_id . "%");
		}

		return $search;
	}
}
