<?php

namespace App\Observers;

use App\Historique;
use App\Models\TypeMateriel;
use Illuminate\Support\Facades\Session;

class TypeMaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeMateriel $typeMateriel
     */
    public function created(TypeMateriel $typeMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeMateriel->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$typeMateriel->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeMateriel $typeMateriel
     */
    public function updated(TypeMateriel $typeMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeMateriel->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$typeMateriel->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeMateriel $typeMateriel
     */
    public function deleted(TypeMateriel $typeMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$typeMateriel->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>