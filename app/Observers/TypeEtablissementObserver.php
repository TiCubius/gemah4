<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeEtablissement;
use Illuminate\Support\Facades\Session;

class TypeEtablissementObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un type d'établissement est créé
     *
     * @param TypeEtablissement $domaineMateriel
     */
    public function created(TypeEtablissement $typeEtablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_etablissement_id" => $typeEtablissement->id,
                "type" => "type/etablissement/created",
                "contenue" => "Le type d'établissement {$typeEtablissement->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type d'établissement est modifié
     *
     * @param TypeEtablissement $domaineMateriel
     */
    public function updated(TypeEtablissement $typeEtablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_etablissement_id" => $typeEtablissement->id,
                "type" => "type/etablissement/modified",
                "contenue" => "Le type d'établissement {$typeEtablissement->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type d'établissement est supprimé
     *
     * @param TypeEtablissement $domaineMateriel
     */
    public function deleted(TypeEtablissement $typeEtablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "type/etablissement/deleted",
                "contenue" => "Le type d'établissement {$typeEtablissement->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>