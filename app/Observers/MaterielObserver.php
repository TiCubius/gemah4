<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\DomaineMateriel;
use App\Models\Materiel;
use Illuminate\Support\Facades\Session;

class MaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un matériel est créé
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(Materiel $materiel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "materiel_id" => $materiel->id,
                "type" => "materiel/created",
                "contenue" => "Le matériel {$materiel->modele} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un matériel est modifié
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(Materiel $materiel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "materiel_id" => $materiel->id,
                "type" => "materiel/modified",
                "contenue" => "Le matériel {$materiel->modele} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un matériel est supprimé
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(Materiel $materiel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "materiel/deleted",
                "contenue" => "Le matériel {$materiel->modele} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>