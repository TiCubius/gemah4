<?php

namespace App\Observers;

use App\Historique;
use App\Models\Academie;
use Illuminate\Support\Facades\Session;

class AcademieObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'une académie est créée
     *
     * @param Academie $academie
     */
    public function created(Academie $academie)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $academie->id,
                "type" => "academie_created",
                "contenue" => "L'académie {$academie->libelle} à été créée par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'une académie est créée
     *
     * @param Academie $academie
     */
    public function updated(Academie $academie)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $academie->id,
                "type" => "academie_updated",
                "contenue" => "L'académie {$academie->libelle} à été modifiée par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'une académie est créée
     *
     * @param Academie $academie
     */
    public function deleted(Academie $academie)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "academie_deleted",
                "contenue" => "L'académie {$academie->libelle} à été supprimée par {$user->nom}"
            ]);
        }
    }
}
?>