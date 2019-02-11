<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaterielExport implements FromCollection, WithHeadings
{
	/**
	 * @var Collection
	 */
	private $materiels;

	public function __construct(Collection $materiels)
	{
		$this->materiels = $materiels;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		return $this->materiels;
	}

	/**
	 * @return array
	 */
	public function headings(): array
	{
		return [
			"id",
			"departement_id",
			"etat_administratif_materiel_id",
			"etat_physique_materiel_id",
			"eleve_id",
			"type_materiel_id",
			"numero_serie",
			"cle_produit",
			"marque",
			"modele",
			"prix_ttc",
			"nom_fournisseur",
			"numero_devis",
			"numero_formulaire_chorus",
			"numero_facture_chorus",
			"numero_ej",
			"date_ej",
			"date_facture",
			"date_service_fait",
			"date_fin_garantie",
			"date_pret",
			"achat_pour",
			"created_at",
			"updated_at",
		];
	}
}
