<?php

namespace App\Observers;

use App\Historique;
use App\Models\Decision;
use Illuminate\Support\Facades\Session;

class DecisionObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'une décision est créée
     *
     * @param Decision $decision
     */
    public function created(Decision $decision)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $decision->id,
                "type" => "decision_created",
                "contenue" => "La décision {$decision->libelle} à été créée par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Decision $decision
     */
    public function updated(Decision $decision)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $decision->id,
                "type" => "decision_updated",
                "contenue" => "La décision {$decision->libelle} à été modifiée par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Decision $decision
     */
    public function deleted(Decision $decision)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "decision_deleted",
                "contenue" => "La décision {$decision->libelle} à été supprimée par {$user->nom}"
            ]);
        }
    }
}
?>