<?php

namespace App\Observers;

use App\Mail\EleveCreatedMail;
use App\Models\Decision;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\Historique;
use App\Models\Materiel;
use App\Models\Responsable;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EleveObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un élève
	 *
	 * @param Eleve $eleve
	 */
	public function created(Eleve $eleve)
	{
		Mail::send(new EleveCreatedMail($eleve));

		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $eleve->id,
				"type"        => "eleve/created",
				"information" => "L'élève {$eleve->nom} {$eleve->prenom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un élève
	 *
	 * @param Eleve $eleve
	 */
	public function updated(Eleve $eleve)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $eleve->id,
				"type"        => "eleve/modified",
				"information" => "L'élève {$eleve->nom} {$eleve->prenom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/**
	 * EVENT - Déclanché lors de la suppression d'un élève
	 *
	 * @param Eleve $eleve
	 */
	public function deleting(Eleve $eleve)
	{
		// On supprime toutes les décisions
		$eleve->decisions()->each(function (Decision $decision) {
			$decision->delete();
		});

		// On supprime tout les documents
		$eleve->documents()->each(function (Document $document) {
			$document->delete();
		});

		// On désaffecte tout les matériels
		$eleve->materiels()->each(function (Materiel $materiel) {
			$materiel->eleve()->dissociate();
			$materiel->save();
		});

		// On détache tout les responsables
		$eleve->responsables()->each(function (Responsable $responsable) use ($eleve) {
			$responsable->touch();
			$responsable->eleves()->detach($eleve);
		});

		// On désaffecte l'établissement
		$eleve->etablissement()->dissociate();

		// On supprime les tickets
		$eleve->tickets()->each(function (Ticket $ticket) {
			$ticket->delete();
		});
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un élève
	 *
	 * @param Eleve $eleve
	 */
	public function deleted(Eleve $eleve)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "eleve/deleted",
				"information" => "L'élève {$eleve->nom} {$eleve->prenom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>