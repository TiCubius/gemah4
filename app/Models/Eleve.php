<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
	protected $fillable = [
		"etablissement_id",
		"academie_id",
		"nom",
		"prenom",
		"code_ine",
		"classe",
		"joker",
		"prix_global",
		"date_naissance",
		"date_rendu_definitive",
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
	 * @param string $prenom
	 * @param        $date_naissance
	 * @param        $code_ine
	 * @return Builder
	 */
	public function scopeSearch($query, $nom, $prenom, $date_naissance, $code_ine): Builder
	{
		// Dans le cas où la variable "nom", "prenom", "email" ou "telephone" est vide, on souhaite ignorer le champs
		// dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
		$nom = $nom ?? "--";
		$prenom = $prenom ?? "--";
		$date_naissance = $date_naissance ?? "--";
		$code_ine = $code_ine ?? "--";

		// On souhaite une requête SQL du type:
		// SELECT * FROM Responsables WHERE (nom LIKE "%--%" OR prenom LIKE "%--%" (...))
		// Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
		return $query->where(function($query) use ($nom, $prenom, $date_naissance, $code_ine) {
			$query->where("nom", "LIKE", "%{$nom}%")
				->orWhere("prenom", "LIKE", "%{$prenom}%")
				->orWhere("date_naissance", "LIKE", "%{$date_naissance}%")
				->orWhere("code_ine", "LIKE", "%{$code_ine}%");
		});
	}

}