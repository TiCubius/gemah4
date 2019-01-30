<?php

namespace App\Observers;

use App\Models\Decision;

class DecisionObserver
{
	/**
	 * Lors de la suppression d'une décision
	 *
	 * @param Decision $decision
	 */
	public function deleting(Decision $decision)
	{
		// On supprime les relations associés à la décision
		$decision->types()->detach();
	}

	/**
	 * Une fois que la décision à été supprimée
	 *
	 * @param Decision $decision
	 */
	public function deleted(Decision $decision)
	{
		// E01 - On supprime le document associé
		$decision->document->delete();
	}
}
