<?php

namespace App\Providers;


use App\Historique;
use App\Models\TypeDocument;
use Illuminate\Support\Facades\Session;

class TypeDocumentObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un type de document est créé
     *
     * @param TypeDocument $typeDocument
     */
    public function created(TypeDocument $typeDocument)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_document_id" => $typeDocument->id,
                "type" => "type/document/created",
                "contenue" => "Le type de document {$typeDocument->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type de document est modifié
     *
     * @param TypeDocument $typeDocument
     */
    public function updated(TypeDocument $typeDocument)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type_document_id" => $typeDocument->id,
                "type" => "type/document//modified",
                "contenue" => "Le type de document {$typeDocument->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un type de document est supprimé
     *
     * @param TypeDocument $typeDocument
     */
    public function deleted(TypeDocument $typeDocument)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "type/document/deleted",
                "contenue" => "Le type de document {$typeDocument->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}