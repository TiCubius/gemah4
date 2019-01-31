<?php

namespace App\Observers;


use App\Models\Historique;
use App\Models\TypeDocument;
use Illuminate\Support\Facades\Session;

class TypeDocumentObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un type de document
	 *
	 * @param TypeDocument $typeDocument
	 */
	public function created(TypeDocument $typeDocument)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"type_document_id" => $typeDocument->id,
				"type"             => "type/document/created",
				"information"      => "Le type de document {$typeDocument->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un type de document
	 *
	 * @param TypeDocument $typeDocument
	 */
	public function updated(TypeDocument $typeDocument)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"          => $user->id,
				"type_document_id" => $typeDocument->id,
				"type"             => "type/document/modified",
				"information"      => "Le type de document {$typeDocument->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un type de document
	 *
	 * @param TypeDocument $typeDocument
	 */
	public function deleted(TypeDocument $typeDocument)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "type/document/deleted",
				"information" => "Le type de document {$typeDocument->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}