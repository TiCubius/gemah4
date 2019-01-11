<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
	public $incrementing = false;
	protected $fillable = [
		"id",
		"nom",
		"type",
		"degre",
		"regime",
		"ville",
		"code_postal",
		"adresse",
		"telephone",
		"enseignant_id",
        "departement_id",
	];

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
	 * Effectue une recherce sur le nom, prénom, email ou téléphone sur Responsable
	 *
	 * @param        $query
	 * @param string $nom
	 * @param        $ville
	 * @param string $telephone
	 * @return Builder
	 */
	public function scopeSearch($query, $nom, $ville, $telephone): Builder
	{
		// Dans le cas où la variable "nom", "prenom", "email" ou "telephone" est vide, on souhaite ignorer le champs
		// dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
		$nom = $nom ?? "--";
		$ville = $ville ?? "--";
		$telephone = $telephone ?? "--";

		// On souhaite une requête SQL du type:
		// SELECT * FROM Responsables WHERE (nom LIKE "%--%" OR prenom LIKE "%--%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		return $query->where(function($query) use ($nom, $ville, $telephone) {
			$query->where("nom", "LIKE", "%{$nom}%")
				->orWhere("ville", "LIKE", "%{$ville}%")
				->orWhere("telephone", "LIKE", "%{$telephone}%");
		});
	}
}
