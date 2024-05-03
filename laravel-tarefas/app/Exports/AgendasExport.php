<?php

namespace App\Exports;

use App\Models\Agenda;
use Maatwebsite\Excel\Concerns\FromCollection;

class AgendasExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return Agenda::all();
        return auth()->user()->agendas()->get();
    }
}
