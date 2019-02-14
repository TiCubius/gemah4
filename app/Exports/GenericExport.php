<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class GenericExport implements FromCollection, WithTitle, WithHeadings
{
    private $table;
    private $data;

    public function __construct(string $table, Collection $data)
    {
        $this->table = $table;
        $this->data  = $data;
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->table;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return collect($this->data->first())->keys()->toArray();
    }
}