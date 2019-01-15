<?php

namespace App\Http\Controllers\Responsables;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Responsable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ConventionController extends Controller
{
    /**
     * GET - Affiche la liste de tous les responsables liés à un élève avec l'état de signature (et la date si défini)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eleves = Eleve::with("responsables")->has("responsables")->get();

        return view("web.conventions.index", compact("eleves"));
    }

    /**
     * PATCH - Met à jour les signatures (et la date de ces dernières) des conventions
     *
     * @param  \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        /** On récupère la liste des élèves ayant un responsable */
        $eleves = Eleve::with("responsables")->has("responsables")->get();

        foreach ($eleves as $eleve) {
            foreach ($eleve->responsables as $responsable) {
                /** Si la convention n'était pas déjà signé mais que la checkbox si, enregistre à la date du coche */
                if ($request->input("eleve-{$eleve->id}_responsable-{$responsable->id}") != null && $responsable->pivot->etat_signature == 0)  {
                    $responsable->pivot->update([
                        "etat_signature" => 1,
                        "date_signature" => Carbon::now()
                    ]);
                }
                /** Si la checbox est décocher, alors on remet à zéro la ligne de la table pivot */
                elseif(($request->input("eleve-{$eleve->id}_responsable-{$responsable->id}") == null))
                {
                    $responsable->pivot->update([
                        "etat_signature" => 0,
                        "date_signature" => null
                    ]);
                }
            }
        }

        return redirect(route("web.conventions.index"));
    }


    /***
     * @param $eleves
     * @return Response
     */
    public function signatures_effectues(): Response
    {
        $titre = "Liste des responsables ayant signé";
        $responsables = Responsable::with("eleves")->has("eleves")->get();
        $etat = 1;

        return PDF::loadView('pdf.signatures', compact('titre', 'responsables', 'etat'))->stream();
    }

    /***
     * @param $eleves
     * @return Response
     */
    public function signatures_manquantes(): Response
    {
        $titre = "Liste des responsables n'ayant pas signé";
        $responsables = Responsable::with("eleves")->has("eleves")->get();
        $etat = 0;

        return PDF::loadView('pdf.signatures', compact('titre', 'responsables', 'etat'))->stream();
    }
}
