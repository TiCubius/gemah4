<?php

namespace App\Http\Controllers\Affectations;

use App\Http\Controllers\Controller;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\EtatMateriel;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AffectationMaterielController extends Controller
{
    public function index(Eleve $eleve, Request $request): View
    {
        $domaines = DomaineMateriel::with("types")->orderBy("nom")->get();
        $etats = EtatMateriel::orderBy("nom")->get();
        $materiels = Materiel::where("eleve_id", "=", NULL);

        if ($request->exists(["type_id", "marque", "modele", "num_serie"])) {
            $searchedMateriels = $materiels->search($request->input("type_id"), $request->input("marque"), $request->input("modele"), $request->input("num_serie"))->get();
        } else {
            $latestCreatedMateriels = $materiels->latestCreated()->take(10)->get();
            $latestUpdatedMateriels = $materiels->latestUpdated()->take(10)->get();
        }

        return view("web.affectations.materiels", compact("eleve", "domaines", "etats", "latestCreatedMateriels", "latestUpdatedMateriels", "searchedMateriels"));
    }

    public function show(Eleve $eleve): View
    {
        $materiels = $eleve->materiels();

        return view("web.affectations.showMateriels", compact("eleve", "materiels"));
    }

    public function attach(Eleve $eleve, Materiel $materiel): RedirectResponse
    {
        if($materiel->eleve_id !== $eleve->id and !($materiel->eleve_id))
        {
            $materiel->update([
                'eleve_id' => $eleve->id
            ]);
            $eleve->update([
                'prix_global' => ($eleve->prix_global + $materiel->prix_ttc)
            ]);
            return redirect()->route("web.scolarites.eleves.show", [$eleve]);
        }

        return redirect()->route("web.scolarites.eleves.show", [$eleve])->withErrors("Le materiel est deja affecte a l'eleve");
    }

    public function detach(Eleve $eleve, Materiel $materiel): RedirectResponse
    {
        if($materiel->eleve_id == $eleve->id)
        {
            $materiel->update(["eleve_id" => NULL]);

            return redirect()->route("web.scolarites.eleves.show", [$eleve]);
        }

        return redirect()->route("web.scolarites.eleves.show", [$eleve])->withErrors("Le matériel est déjà affecté à l'élève");
    }
}
