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

            /** Tri par liaison entre élèves et établissements **/
            if ($request->input("etablissement") == "normal") {
                $searchedEleves = $searchedEleves->haveEtablissement(true);
            } elseif ($request->input("etablissement" == "inverted")) {
                $searchedEleves = $searchedEleves->haveEtablissement(false);
            }

            /** Tri par liaison entre élèves et documents **/
            if ($request->input("document") == "normal") {
                $searchedEleves = $searchedEleves->haveDocuments(true);
            } elseif ($request->input("document") == "inverted") {
                $searchedEleves = $searchedEleves->haveDocuments(false);
            }

            /** Tri par liaison entre élèves et matériels **/
            if ($request->input("materiel") == "normal") {
                $searchedEleves = $searchedEleves->haveMateriels(true);
            } elseif ($request->input("materiel") == "inverted") {
                $searchedEleves = $searchedEleves->haveMateriels(false);
            }

            /** Tri par liaison entre élèves et responsables **/
            if ($request->input("responsable") == "normal") {
                $searchedEleves = $searchedEleves->haveResponsables(true);
            } elseif ($request->input("responsable") == "inverted") {
                $searchedEleves = $searchedEleves->haveResponsables(false);
            }

            /** Tri par dernière création de l'élève **/
            if ($request->input("creation_eleve") == "normal"){
                $searchedEleves = $searchedEleves->orderBy("created_at", "DESC");
            } elseif ($request->input("creation_eleve") == "inverted") {
                $searchedEleves = $searchedEleves->orderBy("created_at", "DESC");
            }

            /** Tri par dernière modification de l'élève **/
            if ($request->input("modification_eleve") == "normal"){
                $searchedEleves = $searchedEleves->orderBy("updated_at", "ASC");
            } elseif ($request->input("modification_eleve") == "inverted") {
                $searchedEleves = $searchedEleves->orderBy("updated_at", "DESC");
            }

            /** Tri par dernière création d'un document **/
            if ($request->input("creation_document") == "normal"){
                $searchedEleves = $searchedEleves->latestDocumentCreated(true);
            } elseif ($request->input("creation_document") == "inverted") {
                $searchedEleves = $searchedEleves->latestDocumentCreated(false);
            }

            /** Tri par dernière modification d'un document **/
            if ($request->input("modification_document") == "normal"){
                $searchedEleves = $searchedEleves->latestDocumentModified(true);
            } elseif ($request->input("modification_document") == "inverted") {
                $searchedEleves = $searchedEleves->latestDocumentModified(false);
            }

            /** Tri par dernier ajout d'un ticket **/
            if ($request->input("creation_ticket") == "normal"){
                $searchedEleves = $searchedEleves->latestTicketCreated(true);
            } elseif ($request->input("creation_ticket") == "inverted") {
                $searchedEleves = $searchedEleves->latestTicketCreated(false);
            }

            /** Tri par dernière modification d'un ticket **/
            if ($request->input("modification_ticket") == "normal"){
                $searchedEleves = $searchedEleves->latestTicketModified(true);
            } elseif ($request->input("modification_ticket") == "inverted") {
                $searchedEleves = $searchedEleves->latestTicketModified(false);
            }

            /** Tri par nom **/
            if ($request->input("alphabetique_nom") == "normal"){
                $searchedEleves = $searchedEleves->orderBy("nom", "ASC");
            } elseif ($request->input("alphabetique_nom") == "inverted") {
                $searchedEleves = $searchedEleves->orderBy("nom", "DESC");
            }

            /** Tri par prenom **/
            if ($request->input("alphabetique_prenom") == "normal"){
                $searchedEleves = $searchedEleves->orderBy("prenom", "ASC");
            } elseif ($request->input("alphabetique_prenom") == "inverted") {
                $searchedEleves = $searchedEleves->orderBy("prenom", "DESC");
            }

            /** Tri par date de naissance **/
            if ($request->input("ordre_naissance") == "normal"){
                $searchedEleves = $searchedEleves->orderBy("date_naissance", "ASC");
            } elseif ($request->input("ordre_naissance") == "inverted") {
                $searchedEleves = $searchedEleves->orderBy("date_naissance", "DESC");
            }

            $searchedEleves = $searchedEleves->get();
        }

        //dd($request);

        return view('web.statistiques.generale', compact("eleves", "types", "academies", "searchedEleves"));
    }
}
