<?php

namespace App\Http\Controllers\Affectations;

use App\Http\Controllers\Controller;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\EtatMateriel;
use App\Models\Materiel;
use Illuminate\Http\Request;

class AffectationMaterielController extends Controller
{
    public function index(Eleve $eleve, Request $request): View
    {
        $domaines = DomaineMateriel::with("types")->orderBy("nom")->get();
        $etats = EtatMateriel::orderBy("nom")->get();
        $materiels = Materiel::where("eleve_id", "=", NULL)->get();
        dd($materiels);

        if ($request->exists(["type_id", "etat_id", "marque", "modele", "num_serie"])) {
            $searchedMateriels = $materiels->search($request->input("type_id"), $request->input("etat_id"), $request->input("marque"), $request->input("modele"), $request->input("num_serie"))->get();
        } else {
            $latestCreatedMateriels = $materiels->latestCreated()->take(10)->get();
            $latestUpdatedMateriels = $materiels->latestUpdated()->take(10)->get();
        }

        return view("web.affectations.materiels", compact("eleve", "domaines", "etats", "latestCreatedMateriels", "latestUpdatedMateriels", "searchedMateriels"));
    }

    public function attach()
    {
        return redirect();
    }

    public function detach()
    {
        return redirect();
    }
}
