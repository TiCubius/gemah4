<?php

namespace App\Providers;

use App\Historique;
use App\Models\Enseignant;
use Illuminate\Support\Facades\Session;

class EnseignantObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Enseignant $enseignant
     */
    public function created(Enseignant $enseignant)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $enseignant->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$enseignant->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Enseignant $enseignant
     */
    public function updated(Enseignant $enseignant)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $enseignant->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$enseignant->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Enseignant $enseignant
     */
    public function deleted(Enseignant $enseignant)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$enseignant->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}