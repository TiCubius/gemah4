<?php

namespace App\Providers;


use App\Historique;
use App\Models\TypeEleve;
use Illuminate\Support\Facades\Session;

class TypeEleveObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeEleve $typeEleve
     */
    public function created(TypeEleve $typeEleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeEleve->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$typeEleve->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeEleve $typeEleve
     */
    public function updated(TypeEleve $typeEleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeEleve->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$typeEleve->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeEleve $typeEleve
     */
    public function deleted(TypeEleve $typeEleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$typeEleve->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}