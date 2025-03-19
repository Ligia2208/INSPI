<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Log;

class ReportReformExport implements FromView, WithEvents
{
    protected $actividades;

    public function __construct($actividades)
    {
        $this->actividades = $actividades;
    }

    /**
     * Método obligatorio de FromView para generar la vista de exportación
     */
    public function view(): View
    {
        try {
            \Log::info("Generando reporte con datos:", ['actividades' => $this->actividades->toArray()]);
    
            return view('exports.reportReform', [
                'actividades' => $this->actividades
            ]);
    
        } catch (\Exception $e) {
            \Log::error("Error al generar la vista para Excel: " . $e->getMessage());
            throw $e;
        }
    }
    

    /**
     * Configuración de estilos para la hoja de Excel
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                try {
                    $sheet = $event->sheet->getDelegate();

                    // 🔹 Columnas a centrar (excepto Justificativo)
                    $columnasCentradas = ['A', 'B', 'C', 'E', 'F', 'G'];
                    foreach ($columnasCentradas as $columna) {
                        if ($sheet->getColumnDimension($columna)) {
                            $sheet->getStyle("{$columna}1:{$columna}1048576")
                                ->getAlignment()
                                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                            
                            $sheet->getColumnDimension($columna)->setAutoSize(true);
                        }
                    }

                    // 🔹 Ajuste para la columna D (Justificativo)
                    if ($sheet->getColumnDimension('D')) {
                        $sheet->getStyle("D1:D1048576")
                            ->getAlignment()
                            ->setWrapText(true)
                            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

                        $sheet->getColumnDimension('D')->setWidth(50); 
                    }

                } catch (\Exception $e) {
                    Log::error("Error al aplicar estilos en Excel: " . $e->getMessage());
                    throw $e;
                }
            },
        ];
    }
}
