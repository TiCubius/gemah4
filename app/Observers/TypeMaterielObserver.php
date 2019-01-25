<?php

namespace App\Observers;

use App\Historique;
use App\Models\TypeMateriel;
use Illuminate\Support\Facades\Session;

class TypeMaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un type de matériel est créé
     *
     * @param TypeMateriel $typeMateriel
     */
    public function created(TypeMateriel $typeMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_materiel_id" => $typeMateriel->id,
                "type" => "type/materiel/created",
                "contenue" => "Le type de matériel {$typeMateriel->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type de matériel est modifié
     *
     * @param TypeMateriel $typeMateriel
     */
    public function updated(TypeMateriel $typeMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_materiel_id" => $typeMateriel->id,
                "type" => "type/materiel/modified",
                "contenue" => "Le type de matériel {$typeMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type de matériel est supprimé
     *
     * @param TypeMateriel $typeMateriel
     */
    public function deleted(TypeMateriel $typeMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "type/materiel/deleted",
                "contenue" => "Le type de matériel {$typeMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>