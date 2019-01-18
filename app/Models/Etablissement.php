<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etablissement extends Model
{
    public $incrementing = false;
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
     * Un établissement appartient à un type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeEtablissement::class);
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
     * Effectue une recherce sur le nom, prénom, email ou téléphone sur Responsable
     *
     * @param        $query
     * @param        $departement
     * @param string $nom
     * @param        $ville
     * @param string $telephone
     * @return Builder
     */
    public function scopeSearch($query, $departementId, $type, $nom, $ville, $telephone): Builder
    {
        // Dans le cas où la variable "nom", "prenom", "email" ou "telephone" est vide, on souhaite ignorer le champs
        // dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
        $departementId = $departementId ?? "--";
        $type = $type ?? "--";
        $nom = $nom ?? "--";
        $ville = $ville ?? "--";
        $telephone = $telephone ?? "--";

        // On souhaite une requête SQL du type:
        // SELECT * FROM Responsables WHERE (nom LIKE "%--%" OR prenom LIKE "%--%" (...))
        // Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
        $search = $query->select("etablissements.*")->where(function ($query) use ($type, $nom, $ville, $telephone) {
            if ($type != "--"){
                $query = $query->orwhere("type_etablissement_id", "LIKE", "%{$type}%");
            }
			if ($nom != "--"){
                $query = $query->orWhere("nom", "LIKE", "%{$nom}%");
            }
			if ($ville != "--"){
                $query = $query->orWhere("ville", "LIKE", "%{$ville}%");
            }
			if ($telephone != "--"){
                $query = $query->orWhere("telephone", "LIKE", "%{$telephone}%");
            }
		});

        if ($departementId !== "--") {
            $search->where("departement_id", $departementId);
        }

        return $search;
    }
}
