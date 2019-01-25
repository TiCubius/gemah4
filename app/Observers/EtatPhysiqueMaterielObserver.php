<?php

namespace App\Observers;

use App\Historique;
use App\Models\DomaineMateriel;
use App\Models\EtatPhysiqueMateriel;
use Illuminate\Support\Facades\Session;

class EtatPhysiqueMaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(EtatPhysiqueMateriel $etatPhysiqueMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $etatPhysiqueMateriel->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$etatPhysiqueMateriel->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(EtatPhysiqueMateriel $etatPhysiqueMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $etatPhysiqueMateriel->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$etatPhysiqueMateriel->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(EtatPhysiqueMateriel $etatPhysiqueMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$etatPhysiqueMateriel->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>