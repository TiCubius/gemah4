<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeEleve;
use Illuminate\Support\Facades\Session;

class TypeEleveObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un type d'élève est créé
     *
     * @param TypeEleve $typeEleve
     */
    public function created(TypeEleve $typeEleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_eleve_id" => $typeEleve->id,
                "type" => "type/eleve/created",
                "contenue" => "Le type d'élève {$typeEleve->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type d'élève est modifié
     *
     * @param TypeEleve $typeEleve
     */
    public function updated(TypeEleve $typeEleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_eleve_id" => $typeEleve->id,
                "type" => "type/eleve/modified",
                "contenue" => "Le type d'élève {$typeEleve->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type d'élève est supprimé
     *
     * @param TypeEleve $typeEleve
     */
    public function deleted(TypeEleve $typeEleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "type/eleve/deleted",
                "contenue" => "Le type d'élève {$typeEleve->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}