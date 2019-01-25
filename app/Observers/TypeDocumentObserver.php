<?php

namespace App\Providers;


use App\Historique;
use App\Models\TypeDocument;
use Illuminate\Support\Facades\Session;

class TypeDocumentObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeDocument $typeDocument
     */
    public function created(TypeDocument $typeDocument)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeDocument->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$typeDocument->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeDocument $typeDocument
     */
    public function updated(TypeDocument $typeDocument)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeDocument->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$typeDocument->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TypeDocument $typeDocument
     */
    public function deleted(TypeDocument $typeDocument)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$typeDocument->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}