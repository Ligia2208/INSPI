<?php

namespace App\Exports;

use App\Models\Planificacion\Poa1\Poa;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReportDetalleExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    /*
    public function collection()
    {
        return Poa::all();
    }
    */

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('exports.reportDetalle', [
            'actividades' => $this->data
        ]);
    }


}
