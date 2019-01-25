<?php

namespace App\Observers;

use App\Historique;
use App\Models\Document;
use Illuminate\Support\Facades\Session;

class DocumentObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(Document $document)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $document->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$document->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(Document $document)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $document->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$document->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(Document $document)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$document->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>