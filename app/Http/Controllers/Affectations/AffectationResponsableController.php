<?php

namespace App\Http\Controllers\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AffectationResponsableController extends Controller
{
    /***
     * Retourne la recherche des responsable n'étant pas en relation avec l'élève indiqué
     *
     * @param Eleve $eleve
     * @param Request $request
     * @return View
     */
    public function index(Eleve $eleve, Request $request): View
    {
        $responsables = Responsable::notRelated($eleve);
        $latestCreatedResponsables = $responsables->latestCreated()->take(10)->get();
        $latestUpdatedResponsables = $responsables->latestUpdated()->take(10)->get();

        if ($request->exists(["nom", "prenom", "email", "telephone"])) {
            $searchedResponsables = $responsables->search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"))->get();
        }

        return view("web.affectations.responsables", compact("eleve", "latestCreatedResponsables", "latestUpdatedResponsables", "searchedResponsables"));
    }

    /***
     * Crée la relation entre l'élève et le responsable indiqué
     *
     * @param Eleve $eleve
     * @param Responsable $responsable
     * @return RedirectResponse
     */
    public function attach(Eleve $eleve, Responsable $responsable): RedirectResponse
    {
        $responsable->eleves()->attach($eleve->id);

        return redirect()->route("web.scolarites.eleves.show", [$eleve]);
    }

    /***
     * Efface la relation entre l'élève et le responsable indiqué
     *
     * @param Eleve $eleve
     * @param Responsable $responsable
     * @return Redirect
     */
    public function detach(Eleve $eleve, Responsable $responsable): Redirect
    {
        $responsable->eleves()->detach($eleve->id);

        return redirect()->route("web.scolarites.eleves.show", [$eleve]);
    }
}
