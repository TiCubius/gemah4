<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\DomaineMateriel;
use App\Models\EtatPhysiqueMateriel;
use Illuminate\Support\Facades\Session;

class EtatPhysiqueMaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un état physique de matériel est créé
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(EtatPhysiqueMateriel $etatPhysiqueMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "etat_physique_materiel_id" => $etatPhysiqueMateriel->id,
                "type" => "etat/physique/materiel/created",
                "contenue" => "L'état physique matériel {$etatPhysiqueMateriel->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un état physique de matériel est modifié
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(EtatPhysiqueMateriel $etatPhysiqueMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "etat_physique_materiel_id" => $etatPhysiqueMateriel->id,
                "type" => "etat/physique/materiel/modified",
                "contenue" => "L'état physique matériel {$etatPhysiqueMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un état physique de matériel est supprimé
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(EtatPhysiqueMateriel $etatPhysiqueMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "etat/physique/materiel/deleted",
                "contenue" => "L'état physique matériel {$etatPhysiqueMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>