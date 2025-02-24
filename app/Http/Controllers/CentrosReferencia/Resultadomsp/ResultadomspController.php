<?php

namespace App\Http\Controllers\CentrosReferencia\Resultadomsp;
include_once dirname(__FILE__)."/phpqrcode/qrlib.php";

use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\Resultado;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use QrCode;

class ResultadomspController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:resultadosmsp']);
    }

    public function index(){
        return view('centrosreferencia.resultadomsp.index');
    }

    public function create(){
        $resultado = new Resultado();
        return view('centrosreferencia.resultadomsp.create', compact('resultado'));
    }

    public function show(Resultado $resultado){
        return view('centrosreferencia.resultadomsp.show', compact('resultado'));
    }

    public function edit(Resultado $resultado){
        return view('centrosreferencia.resultadomsp.edit', compact('resultado'));
    }

    public function informemsp($id){

        $this->fpdf = new Fpdf;
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->AddPage("P", "A4");
        $this->fpdf->Image('descargar.png',12,12,-200);
        $this->fpdf->Cell(50, 20, "",1,0,"C");
        $this->fpdf->Cell(80, 20, "", 1);
        $this->fpdf->Text(80,22,"INFORME DE RESULTADOS");
        $this->fpdf->Cell(60, 20,"",1,0,"C");
        $this->fpdf->Text(147,18,utf8_decode("Coordinación General Técnica"));
        $this->fpdf->Text(146,23,utf8_decode("Dirección Técnica de Vigilancia"));
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(130,10,"",0,0,"C");
        $datetime1 = date_create(date('Y-m-d h:m'));
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(60,28,utf8_decode("Fecha impresión: ".$datetime1->format('d/m/Y - h:m')),0,0,"C");
        $this->fpdf->Ln(18);

        $data = Preanalitica::findOrFail($id);
        $data_muestras = Analitica::where('preanalitica_id','=',$id)->get();
        $unidad = Institucion::findOrFail($data->instituciones_id);
        $paciente = Paciente::findOrFail($data->paciente_id);

        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,7,utf8_decode("Descripción Institución de Salud que referencia"),1,0,"C");
        $this->fpdf->Ln(7);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(190,7,utf8_decode("Institución de Salud: ".$unidad->descripcion),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(190,7,utf8_decode("Clasificación: ".$unidad->clasificacion->descripcion.' - '.$unidad->nivel->descripcion.' - '.$unidad->tipologia->descripcion.' ( '.$unidad->provincia->descripcion.' - '.$unidad->canton->descripcion.' )'),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(80,7,utf8_decode("Fecha atención: ".$data->fecha_atencion),1,0,"L");
        $this->fpdf->Cell(110,7,utf8_decode("Nombre de quien notifica: ".$data->quien_notifica),1,0,"L");
        $this->fpdf->Ln(12);

        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,7,utf8_decode("Información de Recepción de Muestras"),1,0,"C");
        $this->fpdf->Ln(7);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(100,7,utf8_decode("Lugar probable infección: ".$data->probable_infeccion),1,0,"L");
        $this->fpdf->Cell(50,7,utf8_decode("Fecha inicio de sintomas: ".$data->fecha_sintomas),1,0,"L");
        $datetime1 = date_create(date('Y-m-d'));
        $datetime2 = date_create($data->fecha_sintomas);
        $interval = date_diff($datetime2,$datetime1);
        $this->fpdf->Cell(40,7,utf8_decode("Dias evolución: ".$interval->format('%R%a dias')),1,0,"L");
        $this->fpdf->Ln(7);
        if ($data->embarazo=='N'){
            $datemb = 'No';
        }
        else{
            $datemb = 'Si';
        }
        if ($data->laboratorio=='N'){
            $datlab = 'No';
        }
        else{
            $datlab = 'Si';
        }
        $this->fpdf->Cell(40,7,utf8_decode("Embarazada: ".$datemb),1,0,"L");
        $this->fpdf->Cell(50,7,utf8_decode("Semanas de gestación: ".$data->gestacion),1,0,"L");
        $this->fpdf->Cell(40,7,utf8_decode("Muestra Laboratorio: ".$datlab),1,0,"L");
        $this->fpdf->Cell(60,7,utf8_decode("Nombre Laboratorio: ".$data->nombre_laboratorio),1,0,"L");

        $this->fpdf->Ln(12);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,7,utf8_decode("Técnicas Aplicadas"),1,0,"C");
        $this->fpdf->SetFont('Arial', 'B', 7);
        $fecha_lab = '';

        $this->fpdf->Ln(7);
        $this->fpdf->Cell(34,7,utf8_decode("Código muestra"),1,0,"C");
        $this->fpdf->Cell(25,7,utf8_decode("Tipo muestra"),1,0,"C");
        $this->fpdf->Cell(25,7,utf8_decode("Toma muestra"),1,0,"C");
        $this->fpdf->Cell(25,7,utf8_decode("Llegada a CRN"),1,0,"C");
        $this->fpdf->Cell(40,7,utf8_decode("Técnica aplicada"),1,0,"C");
        $this->fpdf->Cell(41,7,utf8_decode("Resultado"),1,0,"C");
        $this->fpdf->SetFont('Arial', '', 7);
        foreach($data_muestras as $muestra){
            $this->fpdf->Ln(7);
            if($muestra->codigo_externo != ''){
                $this->fpdf->Cell(34,7,utf8_decode($muestra->anio_registro.'-'.$muestra->codigo_externo),1,0,"C");
            }
            else{
                $this->fpdf->Cell(34,7,utf8_decode($muestra->codigo_calidad),1,0,"C");
            }

            $this->fpdf->Cell(25,7,utf8_decode($muestra->muestra->descripcion),1,0,"C");
            $this->fpdf->Cell(25,7,utf8_decode($muestra->fecha_toma),1,0,"C");
            $this->fpdf->Cell(25,7,utf8_decode($muestra->fecha_llegada_lab),1,0,"C");
            if($muestra->tecnica_id>0){
                $this->fpdf->Cell(40,7,utf8_decode(substr($muestra->tecnica->descripcion,1,32)),1,0,"L");
                $this->fpdf->Cell(41,7,utf8_decode(substr($muestra->resultado->descripcion,1,32)),1,0,"L");
            }
            else{
                $this->fpdf->Cell(40,7,utf8_decode(""),1,0,"C");
                $this->fpdf->Cell(41,7,utf8_decode(""),1,0,"C");
            }
            $fecha_lab=$muestra->fecha_llegada_lab;
            $fecha_resul=$muestra->fecha_resultado;
            $tecnico = $muestra->usuarior->name;
        }

        $this->fpdf->Ln(12);

        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,7,utf8_decode("Detalle del Resultado"),1,0,"C");
        $this->fpdf->Ln(7);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(190,7,utf8_decode("Evento: ".$data->evento->descripcion." - (".$data->evento->simplificado.")"),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(190,7,utf8_decode("Resultado: ".$data->resultado->descripcion),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,7,utf8_decode("Descripción del resultado encontrado:"),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(190,7,utf8_decode($data->descripcion),1,0,"L");

        $dataqr = $data->sedes->descripcion." - ".$data->crns->descripcion."\n";
        $dataqr .= "Ev: ".$data->evento->descripcion."\n";
        $dataqr .= "Re: ".$data->resultado->descripcion."\n";
        $dataqr .= "Co: ".$data->codigo_calidad."\n";
        $dataqr .= "Va: ".$data->usuarior_id.'-'.$data->fecha_resultado;

        QrCode::png($dataqr,storage_path('app/public/qrcodes/').$data->sedes_id.'-'.$data->crns_id.'-'.$data->anio_registro.'-'.$muestra->codigo_muestra.'.png',QR_ECLEVEL_H,3,1);

        $this->fpdf->Image(storage_path('app/public/qrcodes/').$data->sedes_id.'-'.$data->crns_id.'-'.$data->anio_registro.'-'.$muestra->codigo_muestra.'.png',140,190,37);

        $this->fpdf->Ln(16);
        $this->fpdf->SetFont('Arial', 'B', 7);
        $this->fpdf->Cell(90,7,utf8_decode("Trazabilidad del proceso"),1,0,"C");
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(90,7,utf8_decode("Recepción muestra: ".$data->usuariot->name.' ('.$data->fecha_recepcion.')'),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(90,7,utf8_decode("Llegada al CRN - Laboratorio : ".$fecha_lab),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(80,7,utf8_decode("Analítica: ".$tecnico.' ('.$fecha_resul.')'),1,0,"L");
        $this->fpdf->Ln(7);
        $this->fpdf->Cell(90,7,utf8_decode("Validación resultado: ".$data->usuarior->name.' ('.$data->fecha_resultado.')'),1,0,"L");
        $this->fpdf->Ln(7);

        $this->fpdf->Output();
        exit;
    }

}
