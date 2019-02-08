<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MaterielFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->request = $request;
    }


    /**
     * FILTRE - Recherche sur l'état administratif
     *
     * @param null $term
     * @return Builder|null
     */
        public function etat_administratif_materiel_id($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("etat_administratif_materiel_id", $term);
        }

        return null;
    }

    /**
     * FILTRE - Recherche sur la date de naissance
     *
     * @param null $term
     * @return Builder|null
     */
    public function etat_physique_materiel_id($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("etat_physique_materiel_id", $term);
            return $this->builder->where("etat_physique_materiel_id", $term);
        }

        return null;
    }

    /**
     * FILTRE - Recherche sur le département
     *
     * @param null $term
     * @return Builder
     */
    public function departement_id($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("departement_id", $term);
        }

        return null;
    }

    /**
     * FILTRE - Recherche sur l'établissement
     *
     * @param null $term
     * @return Builder|null
     */
    public function eleve($term = null): ?Builder
    {
        if ($term === "with") {
            return $this->builder->whereHas("eleve");
        } elseif ($term === "without") {
            return $this->builder->whereDoesntHave("eleve");
        }

        return null;
    }

    /**
     * FILTRE - Recherche sur les type de matériels
     *
     * @param null $term
     * @return Builder|null
     */
    public function type_materiel_id($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("type_materiel_id", $term);
        }

        return null;
    }

    /**
     * FILTRE - Recherche sur le numero de serie
     *
     * @param null $term
     * @return Builder|null
     */
    public function numero_serie($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("numero_serie", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILTRE - Recherche sur le prénom
     *
     * @param null $term
     * @return Builder|null
     */
    public function cle_produit($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("cle_produit", "LIKE", "%{$term}%");
        }

        return null;
    }


    public function ordre($term = null): ?Builder
    {
        if ($term === "ASC/created_at") {
            return $this->builder->orderBy("created_at", "ASC");
        } elseif ($term === "DESC/created_at") {
            return $this->builder->orderBy("created_at", "DESC");
        } elseif ($term === "ASC/updated_at") {
            return $this->builder->orderBy("updated_at", "ASC");
        } elseif ($term === "DESC/update_at") {
            return $this->builder->orderBy("updated_at", "DESC");
        } elseif ($term === "ASC/alphabetique") {
            return $this->builder->orderBy("marque", "ASC")->orderBy("modele", "ASC");
        } elseif ($term === "DESC/alphabetique") {
            return $this->builder->orderBy("marque", "DESC")->orderBy("modele", "DESC");
        }

        return null;
    }

    /**
     * FILTRE - Recherche sur la marque
     *
     * @param null $term
     * @return Builder|null
     */
    public function marque($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("marque", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur le modele
     *
     * @param null $term
     * @return Builder|null
     */
    public function modele($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("modele", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur le nom du fournisseur
     *
     * @param null $term
     * @return Builder|null
     */
    public function nom_fournisseur($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("nom_fournisseur", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur le numero de devis
     *
     * @param null $term
     * @return Builder|null
     */
    public function numero_devis($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("numero_devis", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur le numero formulaire chorus
     *
     * @param null $term
     * @return Builder|null
     */
    public function numero_formulaire_chorus($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("numero_formulaire_chorus", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur le numero de facture chorus
     *
     * @param null $term
     * @return Builder|null
     */
    public function numero_facture_chorus($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("numero_facture_chorus", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur le numero ej
     *
     * @param null $term
     * @return Builder|null
     */
    public function numero_ej($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("numero_ej", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur la date ej
     *
     * @param null $term
     * @return Builder|null
     */
    public function date_ej($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("date_ej", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur la date de facture
     *
     * @param null $term
     * @return Builder|null
     */
    public function date_facture($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("date_facture", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur la date de service fait
     *
     * @param null $term
     * @return Builder|null
     */
    public function date_service_fait($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("date_service_fait", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur la date de fin de garantie
     *
     * @param null $term
     * @return Builder|null
     */
    public function date_fin_garantie($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("date_fin_garantie", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche sur la date de pret
     *
     * @param null $term
     * @return Builder|null
     */
    public function date_pret($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("date_pret", "LIKE", "%{$term}%");
        }

        return null;
    }

    /**
     * FILRE - Recherche de materiel acheté pour un eleve precis
     *
     * @param null $term
     * @return Builder|null
     */
    public function achat_pour($term = null): ?Builder
    {
        if ($term) {
            return $this->builder->where("achat_pour", "LIKE", "%{$term}%");
        }

        return null;
    }
}