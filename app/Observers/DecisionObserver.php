<?php

namespace App\Observers;

use App\Mail\DecisionCreatedMail;
use App\Models\Decision;
use Illuminate\Support\Facades\Mail;

class DecisionObserver
{
	/**
	 * EVENT - Déclanché après la création d'une décision
	 *
	 * @param Decision $decision
	 */
	public function created(Decision $decision)
	{
		// Il est nécessaire d'envoyer un E-Mail uniquement
		// si l'élève possède plus d'une décision
		$eleve = $decision->document->eleve;
		if (count($eleve->decisions) > 1) {
			Mail::send(new DecisionCreatedMail($eleve, $decision));
		}
	}

	/**
	 * EVENT - Déchlanché lors de la suppression d'une décision
	 *
	 * @param Decision $decision
	 */
	public function deleting(Decision $decision)
	{
		// On supprime les relations associés à la décision
		$decision->types()->detach();
	}

	/**
	 * EVENT - Déchlanché après la suppression d'une décision
	 *
	 * @param Decision $decision
	 */
	public function deleted(Decision $decision)
	{
		// E01 - On supprime le document associé
		$decision->document->delete();
	}
}
