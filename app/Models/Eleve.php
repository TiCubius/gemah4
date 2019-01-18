<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Eleve extends Model
{

    /**
     * @var array
     */
    protected $dates = [
        "date_naissance",
    ];

    protected $fillable = [
        "etablissement_id",
        "departement_id",
        "nom",
        "prenom",
        "code_ine",
        "classe",
        "joker",
        "prix_global",
        "date_naissance",
        "date_rendu_definitive",
    ];

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
     * Un élève peut avoir plusieurs responsables
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responsables()
    {
        return $this->belongsToMany(Responsable::class, "eleve_responsable")->withPivot('etat_signature', 'date_signature');
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
     * Un élève peut avoir plusieurs documents
     *
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /***
     * Un élève peut avoir plusieurs décisions
     *
     * @return HasManyThrough
     */
    public function decisions(): HasManyThrough
    {
        return $this->hasManyThrough(Decision::class, Document::class);
    }

    /**
     * Un élève appartient à plusieurs types
     *
     * @return BelongsToMany
     */
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(TypeEleve::class);
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
     * Effectue une recherce sur le département, type ET (nom, prénom, email ou téléphone sur élève)
     *
     * @param        $query
     * @param $departement_id
     * @param $type_eleve_id
     * @param string $nom
     * @param string $prenom
     * @param        $date_naissance
     * @param        $code_ine
     * @return Builder
     */
    public function scopeSearch($query, $departement_id, $type_eleve_id, $nom, $prenom, $date_naissance, $code_ine): Builder
    {
        // Dans le cas où la variable "nom", "prenom", "email" ou "telephone" est vide, on souhaite ignorer le champs
        // dans notre requête SQL. Il est extremement peu probable que %--% retourne quoi que ce soit pour ces champs.
        $departement_id = $departement_id ?? "--";
        $type_eleve_id = $type_eleve_id ?? "--";
        $nom = $nom ?? "--";
        $prenom = $prenom ?? "--";
        $date_naissance = $date_naissance ?? "--";
        $code_ine = $code_ine ?? "--";


        // On souhaite une requête SQL du type:
        // SELECT * FROM Responsables WHERE (nom LIKE "%--%" OR prenom LIKE "%--%" (...))
        // Les parenthèses sont indispensable dans le cas où l'on rajoute diverses conditions supplémentaires
        $search = $query->select("eleves.*")->where(function ($query) use ($nom, $prenom, $date_naissance, $code_ine) {
            if ($nom != "--") {
                $query = $query->orWhere("nom", "LIKE", "%{$nom}%");
            }
            if ($prenom != "--") {
                $query = $query->orWhere("prenom", "LIKE", "%{$prenom}%");
            }
            if ($date_naissance != "--") {
                $query = $query->orWhere("date_naissance", "LIKE", "%{$date_naissance}%");
            }
            if ($code_ine != "--") {
                $query = $query->orWhere("code_ine", "LIKE", "%{$code_ine}%");
            }
        });

        if ($departement_id !== "--") {
            $search->where("departement_id", $departement_id);
        }

        if ($type_eleve_id !== "--") {
            $search->type($type_eleve_id);
        }

        return $search;
    }

    /**
     * Recherche un élève avec l'id de type elève donné en paramètre
     *
     * @param $query
     * @param $type_eleve_id
     * @return mixed
     */
    public function scopeType($query, $type_eleve_id)
    {
        return $query->whereHas("types", function ($query) use ($type_eleve_id) {
            $query->where("id", $type_eleve_id);
        });
    }

}
