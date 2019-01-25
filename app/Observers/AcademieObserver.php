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
                "academie_id" => $academie->id,
                "type" => "academie/created",
                "contenue" => "L'académie {$academie->nom} à été créée par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'une académie est modifiée
     *
     * @param Academie $academie
     */
    public function updated(Academie $academie)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "academie_id" => $academie->id,
                "type" => "academie/modified",
                "contenue" => "L'académie {$academie->nom} à été modifiée par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'une académie est supprimée
     *
     * @param Academie $academie
     */
    public function deleted(Academie $academie)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "academie/deleted",
                "contenue" => "L'académie {$academie->nom} à été supprimée par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>