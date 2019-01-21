<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Responsable extends Model
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
		"code_postal",
		"ville",
		"adresse",
		"departement_id",
	];


	/***
	 * Un responsable appartient à un département
	 *
	 * @return BelongsTo
	 */
	public function departement(): BelongsTo
	{
		return $this->belongsTo(Departement::class);
	}

	/***
	 * Un responsable possède plusieurs élèves
	 * [Utilisation d'une table PIVOT]
	 *
	 * @return BelongsToMany
	 */
	public function eleves(): BelongsToMany
	{
		return $this->belongsToMany(Eleve::class)->withPivot('etat_signature', 'date_signature');
	}


	/***
	 * Retourne la liste des responsables non associés à l'élève
	 *
	 * @param Builder $query
	 * @param Eleve   $eleve
	 * @return Builder
	 */
	public function scopeNotRelated(Builder $query, Eleve $eleve): Builder
	{
		return $query->whereDoesntHave('eleves', function ($query) use ($eleve) {
			$query->where("eleve_id", "=", $eleve->id);
		});
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
	 * @param        $query
	 * @param string $nom
	 * @param string $prenom
	 * @param string $email
	 * @param string $telephone
	 * @return Builder
	 */
	public function scopeSearch($query, $nom, $prenom, $email, $telephone, $departementId): Builder
	{
		// Dans le cas où la variable "nom", "prenom", "email" ou "telephone" est vide, on souhaite ignorer le champs
		// dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
		$nom = $nom ?? "--";
		$prenom = $prenom ?? "--";
		$email = $email ?? "--";
		$telephone = $telephone ?? "--";

		// On souhaite une requête SQL du type:
		// SELECT * FROM Responsables WHERE (nom LIKE "%--%" OR prenom LIKE "%--%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		$search = $query->select('responsables.*')->where(function ($query) use ($nom, $prenom, $email, $telephone) {
			if ($nom != "--") {
				$query = $query->orWhere("nom", "LIKE", "%{$nom}%");
			}
			if ($prenom != "--") {
				$query = $query->orWhere("prenom", "LIKE", "%{$prenom}%");
			}
			if ($email != "--") {
				$query = $query->orWhere("email", "LIKE", "%{$email}%");
			}
			if ($telephone != "--") {
				$query = $query->orWhere("telephone", "LIKE", "%{$telephone}%");
			}
		});

		if ($departementId != "--") {
			$search = $search->where("departement_id", $departementId);
		}

		return $search;
	}
}
