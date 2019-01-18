<?php

namespace App\Http\Controllers\Scolarites\Documents;

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
		if (!$eleve->etablissement) {
		    return back()->withErrors("Impossible de générer une convention puisque l'élève n'est affecté à aucun établissement.");
        }
		if ($eleve->decisions->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucune convention.");
		}
		if ($eleve->materiels->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucun matériel.");
		}

        $eleves = $eleve->with("responsables", "etablissement", "decisions", "materiels")->where('id', $eleve->id)->get();

		return PDF::loadView('pdf.conventions', compact('eleves'))->stream();
	}

	/**
	 * Génération du PDF de récapitulatif élève
	 *
	 * @param Eleve $eleve
	 * @return Response|RedirectResponse
	 */
	public function recapitulatifs(Eleve $eleve)
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
	 * @return Response|RedirectResponse
	 */
	public function recuperations(Eleve $eleve)
	{
		if ($eleve->decisions->isEmpty()) {
			return back()->withErrors("Impossible de générer une convention puisque l'élève ne possède aucune convention.");
		}

		$decision = $eleve->decisions[0];

		return PDF::loadView('pdf.recuperations', compact('eleve', 'decision'))->stream();
	}
}
