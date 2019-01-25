<?php

namespace App\Observers;

use App\Historique;
use App\Models\TypeEtablissement;
use Illuminate\Support\Facades\Session;

class TypeEtablissementObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeEtablissement $domaineMateriel
     */
    public function created(TypeEtablissement $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $domaineMateriel->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeEtablissement $domaineMateriel
     */
    public function updated(TypeEtablissement $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $domaineMateriel->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeEtablissement $domaineMateriel
     */
    public function deleted(TypeEtablissement $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>