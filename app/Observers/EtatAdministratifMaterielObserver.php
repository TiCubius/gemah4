<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\EtatAdministratifMateriel;
use Illuminate\Support\Facades\Session;

class EtatAdministratifMaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un état administratif de matériel est créé
     *
     * @param EtatAdministratifMateriel $etatAdministratifMateriel
     */
    public function created(EtatAdministratifMateriel $etatAdministratifMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "etat_administratif_materiel_id" => $etatAdministratifMateriel->id,
                "type" => "etat/administratif/materiel/created",
                "contenue" => "L'état administratif matériel {$etatAdministratifMateriel->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un état administratif de matériel est modifié
     *
     * @param EtatAdministratifMateriel $etatAdministratifMateriel
     */
    public function updated(EtatAdministratifMateriel $etatAdministratifMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "etat_administratif_materiel_id" => $etatAdministratifMateriel->id,
                "type" => "etat/administratif/materiel/modified",
                "contenue" => "L'état administratif matériel {$etatAdministratifMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un état administratif de matériel est supprimé
     *
     * @param EtatAdministratifMateriel $etatAdministratifMateriel
     */
    public function deleted(EtatAdministratifMateriel $etatAdministratifMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "etat/administratif/materiel/deleted",
                "contenue" => "L'état administratif matériel {$etatAdministratifMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>