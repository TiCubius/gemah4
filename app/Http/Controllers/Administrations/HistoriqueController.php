<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Historique;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
    /***
     * GET - Retourne l'index de l'historique
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $historiques = Historique::orderBy("created_at", "DESC")->with(
            "user",
            "region",
            "academie",
            "departement",
            "responsable",
            "enseignant",
            "etablissement",
            "typeEtablissement",
            "eleve",
            "typeEleve",
            "ticket",
            "typeTicket",
            "document",
            "typeDocument",
            "domaineMateriel",
            "etatAdministratifMateriel",
            "etatPhysiqueMateriel",
            "materiel",
            "domaineMateriel",
            "typeMateriel",
            "service",
            "utilisateur"
        )->get();

        return view("web.administrations.historiques.index", compact("historiques"));
    }

    /***
     * GET - Retourne une ligne de l'historique
     *
     * @param Historique $historique
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Historique $historique)
    {
        return view("web.administrations.historiques.show", compact("historique"));
    }
}
