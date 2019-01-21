<?php

namespace App\Http\Controllers\Statistiques;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\TypeEleve;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatistiquesController extends Controller
{
    /***
     * GET - Affiche l'index du menu Statistiques de l'application
     *
     * @return View
     */
    public function index(): View
    {
        return view('web.statistiques.index');
    }

    /***
     * @param Request $request
     * @return View
     */
    public function generale(Request $request): View
    {
        $eleves = Eleve::all();
        $types = TypeEleve::all();
        $academies = Academie::with("departements")->get();

        if ($request->exists(["departement_id", "type_eleve_id", "nom", "prenom", "date_naissance", "code_ine", "eleve_id",])) {
            $searchedEleves = Eleve::search($request->input("departement_id"), $request->input("type_eleve_id"), $request->input("nom"), $request->input("prenom"), $request->input("date_naissance"), $request->input("code_ine"), $request->input("eleve_id"));

            if ($request->input("etablissement") == "with") {
                $searchedEleves = $searchedEleves->haveEtablissement(true);
            } elseif ($request->input("etablissement" == "without")) {
                $searchedEleves = $searchedEleves->haveEtablissement(false);
            }

            if ($request->input("document") == "with") {
                $searchedEleves = $searchedEleves->haveDocuments(true);
            } elseif ($request->input("document") == "without") {
                $searchedEleves = $searchedEleves->haveDocuments(false);
            }

            if ($request->input("materiel") == "with") {
                $searchedEleves = $searchedEleves->haveMateriels(true);
            } elseif ($request->input("materiel") == "without") {
                $searchedEleves = $searchedEleves->haveMateriels(false);
            }

            if ($request->input("responsable") == "with") {
                $searchedEleves = $searchedEleves->haveResponsables(true);
            } elseif ($request->input("responsable") == "without") {
                $searchedEleves = $searchedEleves->haveResponsables(false);
            }


            if ($request->input("creation_eleve") == "normal"){
                $searchedEleves = $searchedEleves->orderBy("created_at", "DESC");
            } elseif ($request->input("creation_eleve") == "inverted") {
                $searchedEleves = $searchedEleves->orderBy("created_at", "DESC");
            }

            if ($request->input("modification_eleve") == "normal"){
                $searchedEleves = $searchedEleves->orderBy("updated_at", "ASC");
            } elseif ($request->input("modification_eleve") == "inverted") {
                $searchedEleves = $searchedEleves->orderBy("updated_at", "DESC");
            }

            if ($request->input("creation_document") == "normal"){
                $searchedEleves = $searchedEleves->latestDocumentCreated(true);
            } elseif ($request->input("creation_document") == "inverted") {
                $searchedEleves = $searchedEleves->latestDocumentCreated(false);
            }

            if ($request->input("modification_document") == "normal"){
                $searchedEleves = $searchedEleves->latestDocumentModified(true);
            } elseif ($request->input("modification_document") == "inverted") {
                $searchedEleves = $searchedEleves->latestDocumentModified(false);
            }

            if ($request->input("creation_ticket") == "normal"){
                $searchedEleves = $searchedEleves->(true);
            } elseif ($request->input("creation_ticket") == "inverted") {
                $searchedEleves = $searchedEleves->(false);
            }

            if ($request->input("modification_ticket") == "normal"){
                $searchedEleves = $searchedEleves->(true);
            } elseif ($request->input("modification_ticket") == "inverted") {
                $searchedEleves = $searchedEleves->(false);
            }

            $searchedEleves = $searchedEleves->get();
        }

        /**
         * Filtre via controller :
                    * Création élève
                    * Modification élève
                    * Création document
                    * Modification document
                    * Création ticket     \ Gérer les
                    * Modification ticket / messages à travers ces derniers
         *
         * Filtre via JS (pas à traiter normalement):
                    * Ordre alphabétique par nom
                    *                        prénom
                    * Ordre chronologique par date de naissance
         */

        //dd($request);

        return view('web.statistiques.generale', compact("eleves", "types", "academies", "searchedEleves"));
    }
}
