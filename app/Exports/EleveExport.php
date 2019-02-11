<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EleveExport implements FromCollection, WithHeadings
{
	/**
	 * @var Collection
	 */
	private $eleves;

	public function __construct(Collection $eleves)
	{
		$this->eleves = $eleves;
	}

	/**
	 * @return Collection
	 */
	public function collection(): Collection
	{
		return $this->eleves;
	}

	/**
	 * @return array
	 */
	public function headings(): array
	{
		return [
			"id",
			"etablissement_id",
			"departement_id",
			"nom",
			"prenom",
			"code ine",
			"classe",
			"joker",
			"prix global",
			"date de naissance",
			"date de rendu definitive",
			"created_at",
			"updated_at",
		];
	}
}
