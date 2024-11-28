<?php

namespace App\Http\Controllers\CentrosReferencia\Postanalitica;

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Paciente;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class PostanaliticaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:postanaliticas']);
    }

    public function index(){
        return view('centrosreferencia.postanalitica.index');
    }

    public function create(){
        $postanalitica = new Postanalitica();
        return view('centrosreferencia.postanalitica.create', compact('postanalitica'));
    }

    public function show(Postanalitica $postanalitica){
        return view('centrosreferencia.postanalitica.show', compact('postanalitica'));
    }

    public function edit(Postanalitica $postanalitica){
        return view('centrosreferencia.postanalitica.edit', compact('postanalitica'));
    }

    public function informep($id){

        $this->fpdf = new Fpdf;
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->AddPage("P", "A4");
        $this->fpdf->Image('descargar.png',9,21,-180);
        $this->fpdf->Cell(50, 40, "",1,0,"C");
        $this->fpdf->Cell(80, 20, "", 1);
        $this->fpdf->Text(80,18,"INFORME DE RESULTADOS");
        $this->fpdf->Text(74,24,"NOTIFICACION Y CIERRE DE CASO");
        $this->fpdf->Cell(30, 10, utf8_decode("Código:"),1,0,"C");
        $this->fpdf->Cell(30, 10, "F-DIPC-004",1,0,"C");
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(130,10,"",0,0,"C");
        $this->fpdf->Cell(30, 10, utf8_decode("Edición"),1,0,"C");
        $this->fpdf->Cell(30, 10, "005",1,0,"C");
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(50,20,"",0,0,"C");
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Text(72,37,"Macro-Proceso");
        $this->fpdf->Text(61,41,utf8_decode("Coordinación General Técnica"));
        $this->fpdf->Text(67,45,utf8_decode("Dirección de Vigilancia"));
        $this->fpdf->Cell(43, 20, "",1);
        $this->fpdf->Cell(37, 20, "",1,0,"C");
        $this->fpdf->Text(110,37,"Proceso Interno");
        $this->fpdf->Text(105,41,utf8_decode("Dirección de Vigilancia"));
        $this->fpdf->Text(110,45,utf8_decode("Epidemiológica"));
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 20, utf8_decode("Fecha Aprobación"),1,0,"C");
        $this->fpdf->Cell(30, 20, "28/03/2019",1,0,"C");
        $this->fpdf->Ln(24);

        $data = Analitica::findOrFail($id);
        $unidad = Institucion::findOrFail($data->preanalitica->instituciones_id);
        $paciente = Paciente::findOrFail($data->preanalitica->paciente_id);

        //dd($data, $unidad, $paciente);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->Cell(190,7,utf8_decode("Institución de Salud: ".$unidad->descripcion),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(190,7,utf8_decode("Clasificación: ".$unidad->clasificacion->descripcion.' - '.$unidad->nivel->descripcion.' - '.$unidad->tipologia->descripcion.' ( '.$unidad->provincia->descripcion.' - '.$unidad->canton->descripcion.' )'),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(80,7,utf8_decode("Fecha atención: ".$data->preanalitica->fecha_atencion),1,0,"L");
        $this->fpdf->Cell(110,7,utf8_decode("Nombre de quien notifica: ".$data->preanalitica->quien_notifica),1,0,"L");

        $this->fpdf->Ln(20);
        $this->fpdf->Cell(190, 10, utf8_decode("Por la presente se deja constancia de la conformidad en cuanto a la entrega y recepción de los bienes muebles."),0,0,"L");
        $this->fpdf->Ln(12);
        $this->fpdf->MultiCell(190, 6, utf8_decode("OBSERVACIONES: Esta constatación física corresponde al periodo 2024, según cronograma aprobado por  la Máxima  Autoridad. Esta Acta hace referencia a los Bienes de la Administración."));

        $this->fpdf->Ln(10);
        $this->fpdf->Cell(95, 10, utf8_decode("Entrega:"),0,0,"C");
        $this->fpdf->Cell(95, 10, utf8_decode("Recibe"),0,0,"C");
        $this->fpdf->Ln(20);
        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C");
        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C");
        $this->fpdf->Ln(5);

        $this->fpdf->Output();
        exit;
    }
}
