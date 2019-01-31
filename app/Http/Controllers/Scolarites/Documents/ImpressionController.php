<?php

namespace App\Http\Controllers\Scolarites\Documents;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Parametre;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ImpressionController extends Controller
{

	/**
	 * GET - Génération du PDF de l'autorisation CNIL
	 *
	 * @param Eleve $eleve
	 * @return Response|RedirectResponse
	 */
	public function autorisations(Eleve $eleve)
	{
		if ($eleve->responsables->isEmpty()) {
			return back()->withErrors("Impossible de générer un PDF d'autorisation puisque l'élève n'est affecté à aucun responsable.");
		}

		return PDF::loadView('pdf.autorisations', compact('eleve'))->stream();
	}

	/**
	 * Génération du PDF de consignes d'utilisateur du matériel
	 *
	 * @return Response
	 */
	public function consignes(): Response
	{
		return PDF::loadView('pdf.consignes')->stream();
	}

	/**
	 * GET - Génération du PDF de convention
	 *
	 * @param Eleve $eleve
	 * @return Response|RedirectResponse
	 */
	public function conventions(Eleve $eleve)
	{
		$errors = [];
		if ($eleve->responsables->isEmpty()) {
			$errors[] = "Impossible de générer une convention puisque l'élève n'est affecté à aucun responsable.";
		}
		if (!$eleve->etablissement) {
			$errors[] = "Impossible de générer une convention puisque l'élève n'est affecté à aucun établissement.";
		}
		if ($eleve->decisions->isEmpty()) {
			$errors[] = "Impossible de générer une convention puisque l'élève ne possède aucune décision.";
		}
		if ($eleve->materiels->isEmpty()) {
			$errors[] = "Impossible de générer une convention puisque l'élève ne possède aucun matériel.";
		}
		if (!$eleve->types->contains("libelle", "Matériel")) {
			$errors[] = "Impossible de générer une convention puisque l'élève n'est pas de type matériel.";
		}

		if (count($errors) >= 1) {
			return back()->withErrors($errors);
		}

		// On recherche les données de l'élève
		$eleves = $eleve->with("responsables", "etablissement", "decisions", "materiels")->where('id', $eleve->id)->get();

		// Récupération de tout les paramètres pour imprimer la convention
		$allParametres = Parametre::conventions(42)->get();
		$parametres = [];
		foreach ($allParametres as $parametre) {
			$parametres[$parametre->key] = $parametre->value;
		}

		return PDF::loadView('pdf.conventions', compact('eleves', 'parametres'))->stream();
	}

	/**
	 * GET - Génération du PDF de récapitulatif élève
	 *
	 * @param Eleve $eleve
	 * @return Response|RedirectResponse
	 */
	public function recapitulatifs(Eleve $eleve)
	{
		return PDF::loadView('pdf.recapitulatifs', compact('eleve'))->stream();
	}

	/**
	 * GET - Génération du PDF de récépissé de récupération de matériel
	 *
	 * @param Eleve $eleve
	 * @return Response|RedirectResponse
	 */
	public function recuperations(Eleve $eleve)
	{
		if ($eleve->decisions->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucune décision.");
		}

		return PDF::loadView('pdf.recuperations', compact('eleve'))->stream();
	}
}
