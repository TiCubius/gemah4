<?php

namespace App\Observers;

use App\Historique;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use Illuminate\Support\Facades\Session;

class EleveObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(Eleve $eleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $eleve->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$eleve->nom} {$eleve->prenom} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(Eleve $eleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $eleve->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$eleve->nom} {$eleve->prenom} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(Eleve $eleve)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$eleve->nom} {$eleve->prenom} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>