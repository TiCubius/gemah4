<?php

namespace App\Observers;

use App\Historique;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Session;

class UtilisateurObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un utilisateur est créé
     *
     * @param Utilisateur $utilisateur
     */
    public function created(Utilisateur $utilisateur)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "utilisateur_id" => $utilisateur->id,
                "type" => "utilisateur/created",
                "contenue" => "L'utilisateur {$utilisateur->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un utilisateur est modifié
     *
     * @param Utilisateur $utilisateur
     */
    public function updated(Utilisateur $utilisateur)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "utilisateur_id" => $utilisateur->id,
                "type" => "utilisateur/modified",
                "contenue" => "L'utilisateur {$utilisateur->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un utilisateur est supprimé
     *
     * @param Utilisateur $utilisateur
     */
    public function deleted(Utilisateur $utilisateur)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "utilisateur/deleted",
                "contenue" => "L'utilisateur {$utilisateur->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>