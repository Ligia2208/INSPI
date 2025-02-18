<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;

class ReportPOAExport implements FromView, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.reportPOA', [
            'actividades' => $this->data
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Columnas a modificar
                $columnas = ['A', 'B', 'C', 'D', 'F'];

                foreach ($columnas as $columna) {
                    // Aplicar "Ajustar Texto"
                    $sheet->getStyle("{$columna}1:{$columna}1048576") // Hasta el máximo de filas
                        ->getAlignment()
                        ->setWrapText(true);

                    // Establecer el ancho de columna
                    $sheet->getColumnDimension($columna)->setWidth(57);
                }
            },
        ];
    }
}

