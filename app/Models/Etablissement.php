<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etablissement extends Model
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
		"degre",
		"regime",
		"ville",
		"code_postal",
		"adresse",
		"telephone",
		"enseignant_id",
		"departement_id",
		"type_etablissement_id",
	];


	/**
	 * Un établissement appartient à un type d'établissement
	 *
	 * @return BelongsTo
	 */
	public function type(): BelongsTo
	{
		return $this->belongsTo(TypeEtablissement::class, "type_etablissement_id");
	}

    /**
     * Un établissement peut ête lié à plusieurs élèves
     *
     * @return HasMany
     */
    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
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
	 * Effectue une recherce sur le nom, prénom, email ou téléphone sur Responsable
	 *
	 * @param             $query
	 * @param string      $departementId
	 * @param string      $type
	 * @param string|null $nom
	 * @param string|null $ville
	 * @param string|null $telephone
	 * @return Builder
	 */
	public function scopeSearch($query, ?string $departementId, ?string $type, ?string $nom, ?string $ville, ?string $telephone): Builder
	{
		// On souhaite une requête SQL du type:
		// SELECT * FROM etablissements WHERE (nom LIKE "%$...%" OR ville LIKE "%...%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		$search = $query->select("etablissements.*")->where(function ($query) use ($type, $nom, $ville, $telephone) {
			if ($type) {
				$query = $query->orwhere("type_etablissement_id", "LIKE", "%{$type}%");
			}
			if ($nom) {
				$query = $query->orWhere("nom", "LIKE", "%{$nom}%");
			}
			if ($ville) {
				$query = $query->orWhere("ville", "LIKE", "%{$ville}%");
			}
			if ($telephone) {
				$query = $query->orWhere("telephone", "LIKE", "%{$telephone}%");
			}
		});

		if ($departementId) {
			$search->where("departement_id", $departementId);
		}

		return $search;
	}
}
