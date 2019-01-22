<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enseignant extends Model
{
	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"civilite",
		"nom",
		"prenom",
		"email",
		"telephone",
		"departement_id",
	];


	/**
	 * Un enseignant possède plusieurs décisions
	 *
	 * @return HasMany
	 */
	public function decisions(): HasMany
	{
		return $this->hasMany(Decision::class);
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
	 * @param string      $nom
	 * @param string      $prenom
	 * @param string      $email
	 * @param string|null $telephone
	 * @param string|null $departementId
	 * @return Builder
	 */
	public function scopeSearch($query, ?string $nom, ?string $prenom, ?string $email, ?string $telephone, ?string $departementId): Builder
	{
		// On souhaite une requête SQL du type:
		// SELECT * FROM enseignants WHERE (nom LIKE "%$...%" OR prenom LIKE "%...%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		$search = $query->select('enseignants.*')->where(function ($query) use ($nom, $prenom, $email, $telephone) {
			if ($nom) {
				$query = $query->orWhere("nom", "LIKE", "%{$nom}%");
			}
			if ($prenom) {
				$query = $query->orWhere("prenom", "LIKE", "%{$prenom}%");
			}
			if ($email) {
				$query = $query->orWhere("email", "LIKE", "%{$email}%");
			}
			if ($telephone) {
				$query = $query->orWhere("telephone", "LIKE", "%{$telephone}%");
			}
		});

		if ($departementId != "--") {
			$search = $search->where("departement_id", $departementId);
		}

		return $search;
	}
}
