<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Historique;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DocumentObserver
{
	/***
	 * Ajoute une ligne à l'historique dès qu'un document est créé
	 *
	 * @param Document $document
	 */
	public function created(Document $document)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"     => $user["id"],
				"eleve_id"    => $document->eleve->id,
				"document_id" => $document->id,
				"type"        => "document/created",
				"contenue"    => "Le document {$document->nom} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un document est modifié
	 *
	 * @param Document $document
	 */
	public function updated(Document $document)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"     => $user["id"],
				"eleve_id"    => $document->eleve->id,
				"document_id" => $document->id,
				"type"        => "document/modified",
				"contenue"    => "Le document {$document->nom} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un document est supprimé
	 *
	 * @param Document $document
	 */
	public function deleted(Document $document)
	{
		if ($document->typeDocument->libelle == "Décision") {
			// On supprime la décision
			Storage::delete('public/decisions/' . $document->path);
		} else {
			// On supprime le document
			Storage::delete('public/documents/' . $document->path);
		}

		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"eleve_id" => $document->eleve->id,
				"type"     => "document/deleted",
				"contenue" => "Le document {$document->nom} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>