<?php

namespace App\Observers;

use App\Historique;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Session;

class UtilisateurObserver
{
    /***
     * @param Utilisateur $utilisateur
     */
    public function created(Utilisateur $utilisateur)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $utilisateur->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$utilisateur->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * @param Utilisateur $utilisateur
     */
    public function updated(Utilisateur $utilisateur)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $utilisateur->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$utilisateur->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * @param Utilisateur $utilisateur
     */
    public function deleted(Utilisateur $utilisateur)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$utilisateur->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>