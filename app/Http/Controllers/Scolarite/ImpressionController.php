<?php

namespace App\Http\Controllers\Scolarite;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ImpressionController extends Controller
{

	/**
	 * Génération du PDF de l'autorisation CNIL
	 *
	 * @param Eleve $eleve
	 * @return Response|RedirectResponse
	 */
	public function autorisations(Eleve $eleve): Response
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
	 * Génération du PDF de convention
	 *
	 * @param Eleve $eleve
	 * @return Response|RedirectResponse
	 */
	public function conventions(Eleve $eleve)
	{
		if ($eleve->responsables->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève n'est affecté à aucun responsable.");
		}
		if ($eleve->decisions->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucune convention.");
		}
		if ($eleve->materiels->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucun matériel.");
		}

		$decision = $eleve->decisions->sortBy("created_at")->last();
//		return view("pdf.conventions", compact("eleve", "decision"));
		return PDF::loadView('pdf.conventions', compact('eleve', 'decision'))->stream();
	}

	/**
	 * Génération du PDF de récapitulatif élève
	 *
	 * @param Eleve $eleve
	 * @return Response
	 */
	public function recapitulatifs(Eleve $eleve): Response
	{
		if ($eleve->responsables->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève n'est affecté à aucun responsable.");
		}
		if ($eleve->decisions->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucune convention.");
		}
		if ($eleve->materiels->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucun matériel.");
		}

		return PDF::loadView('pdf.recapitulatifs', compact('eleve'))->stream();
	}

	/**
	 * Génération du PDF de récépissé de récupération de matériel
	 *
	 * @param Eleve $eleve
	 * @return Response
	 */
	public function recuperations(Eleve $eleve): Response
	{
		$decision = $eleve->decisions[0];

		return PDF::loadView('pdf.recuperations', compact('eleve', 'decision'))->stream();
	}
}
