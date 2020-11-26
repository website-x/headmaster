<?php

namespace App\Exports;

use App\Models\Office;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class OfficeExport implements FromCollection
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Office::all();
    }
}
