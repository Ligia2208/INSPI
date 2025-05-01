<?php

namespace App\Http\Controllers\CentrosReferencia\Postanaliticap;
include_once dirname(__FILE__)."/phpqrcode/qrlib.php";
use App\Http\Controllers\Controller;
use App\Models\CentrosReferencia\Postanalitica;
use App\Models\CentrosReferencia\Preanalitica;
use App\Models\CentrosReferencia\Institucion;
use App\Models\CentrosReferencia\Analitica;
use App\Models\CentrosReferencia\Paciente;
use App\Models\CentrosReferencia\Crn;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use QrCode;

class PostanaliticapController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:postanaliticas']);
    }

    public function index(){
        return view('centrosreferencia.postanaliticap.index');
    }

    public function create(){
        $postanalitica = new Postanalitica();
        return view('centrosreferencia.postanaliticap.create', compact('postanalitica'));
    }

    public function show(Preanalitica $postanalitica){

        $muestras = Analitica::where('estado','=','A')->where('preanalitica_id','=',$postanalitica->id)->get();
        return view('centrosreferencia.postanaliticap.show', compact('postanalitica','muestras'));
    }

    public function edit(Postanalitica $postanalitica){
        $muestras = Analitica::where('estado','=','A')->where('preanalitica_id','=',$postanalitica->id)->get();
        $pre = Preanalitica::findOrFail($postanalitica->id);
        return view('centrosreferencia.postanaliticap.edit', compact('postanalitica','muestras','pre'));
    }

    public function informep($id){

        $data = Preanalitica::findOrFail($id);
        $data_muestras = Analitica::where('preanalitica_id','=',$id)->get();
        $codigo_muestra = Analitica::where('preanalitica_id','=',$id)->first()->codigo_calidad;
        $codigom = substr($codigo_muestra, 0, -3);
        $laboratorio = Crn::findOrFail($data->crns_id);
        $unidad = Institucion::findOrFail($data->instituciones_id);
        $paciente = Paciente::findOrFail($data->paciente_id);

        $this->fpdf = new Fpdf;
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->AddPage("P", "A4");
        $this->fpdf->Image('descargar.png',17,10,-200);
        $this->fpdf->Cell(60, 17, "",1,0,"C");
        $this->fpdf->Cell(70, 17, "", 1);
        $this->fpdf->Text(85,20,"INFORME DE RESULTADOS");
        $this->fpdf->Cell(60, 17,"",1,0,"C");
        $this->fpdf->Text(147,17,utf8_decode("Coordinación General Técnica"));
        $this->fpdf->Text(146,22,utf8_decode("Dirección Técnica de Vigilancia"));
        $this->fpdf->Ln(17);
        $this->fpdf->SetFillColor(237, 236, 235);
        $this->fpdf->Cell(190,8,utf8_decode($laboratorio->titulo),1,0,"C",true);
        $this->fpdf->Ln(6);
        $this->fpdf->SetFont('Arial', '', 9);

        $this->fpdf->Cell(120,13,utf8_decode("Código muestra: ".$codigom),0,0,"L");
        $this->fpdf->Cell(70,13,utf8_decode("Fecha impresión: ".date("d/m/Y").' '.date("H:i:s")),0,0,"R");
        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(159,6.5,utf8_decode("Descripción Institución de Salud que referencia"),1,0,"C",true);
        $this->fpdf->Ln(6.5);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(159,6.5,utf8_decode("Institución de Salud: ".$unidad->descripcion),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(159,6.5,utf8_decode("Clasificación: ".$unidad->clasificacion->descripcion.' - '.$unidad->nivel->descripcion.' - '.$unidad->tipologia->descripcion.' ( '.$unidad->provincia->descripcion.' - '.$unidad->canton->descripcion.' )'),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(85,6.5,utf8_decode("Nombre de quien notifica: ".$data->quien_notifica),1,0,"L");
        $this->fpdf->Cell(74,6.5,utf8_decode("Fecha atención: ".$data->fecha_atencion),1,0,"L");

        $this->fpdf->Ln(9);

        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,6.5,utf8_decode("Datos Personales del Paciente"),1,0,"C",true);
        $this->fpdf->Ln(6.5);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(50,6.5,utf8_decode("Identidad: ".$paciente->identidad),1,0,"L");
        $this->fpdf->Cell(100,6.5,utf8_decode("Nombres Completos: ".$paciente->apellidos.' '.$paciente->nombres),1,0,"L");
        $this->fpdf->Cell(40,6.5,utf8_decode("Sexo: ".$paciente->sexo->descripcion),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(50,6.5,utf8_decode("Fecha de Nacimiento: ".$paciente->fechanacimiento),1,0,"L");
        $tiempo = strtotime($paciente->fechanacimiento);
        $ahora = time();
        $edad = ($ahora-$tiempo)/(60*60*24*365.25);
        $edad = floor($edad);
        $this->fpdf->Cell(40,6.5,utf8_decode("Edad: ".$edad.' años'),1,0,"L");
        $this->fpdf->Cell(100,6.5,utf8_decode("Nacionalidad: ".$paciente->nacionalidad->nacionalidad),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(100,6.5,utf8_decode("Dirección: ".$paciente->direccion),1,0,"L");
        $this->fpdf->Cell(50,6.5,utf8_decode("Zonificación: ".$paciente->provincia->descripcion.' -'.$paciente->canton->descripcion ),1,0,"L");
        $this->fpdf->Cell(40,6.5,utf8_decode("Teléfono: ".$paciente->telefono ),1,0,"L");
        $this->fpdf->Ln(9);

        /* $this->fpdf->SetFont('Arial', 'B', 8);
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
        $this->fpdf->Ln(9);*/


        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,6.5,utf8_decode("Técnicas Aplicadas"),1,0,"C",true);
        $this->fpdf->SetFont('Arial', 'B', 7);
        $fecha_lab = '';

        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(34,6.5,utf8_decode("Código muestra"),1,0,"C");
        $this->fpdf->Cell(25,6.5,utf8_decode("Tipo muestra"),1,0,"C");
        $this->fpdf->Cell(25,6.5,utf8_decode("Toma muestra"),1,0,"C");
        $this->fpdf->Cell(25,6.5,utf8_decode("Recepción en CRN"),1,0,"C");
        $this->fpdf->Cell(40,6.5,utf8_decode("Técnica aplicada"),1,0,"C");
        $this->fpdf->Cell(41,6.5,utf8_decode("Resultado"),1,0,"C");
        $this->fpdf->SetFont('Arial', '', 7);
        $i=0;
        $this->fpdf->Ln(6.5);
        foreach($data_muestras as $muestra){
            
            //$this->fpdf->Ln(6.5);
            /* if($muestra->codigo_externo != ''){
                $this->fpdf->Cell(34,7,utf8_decode($muestra->codigo_externo.'-'.$muestra->anio_registro),1,0,"C");
            }
            else{
                $this->fpdf->Cell(34,7,utf8_decode($muestra->codigo_calidad),1,0,"C");
            } */

            $this->fpdf->Cell(34,6.5,utf8_decode($muestra->codigo_calidad),1,0,"C");

            $this->fpdf->Cell(25,6.5,utf8_decode(substr($muestra->muestra->descripcion,0,15)),1,0,"C");
            $this->fpdf->Cell(25,6.5,utf8_decode($muestra->fecha_toma),1,0,"C");
            $this->fpdf->Cell(25,6.5,utf8_decode($muestra->fecha_llegada_lab),1,0,"C");
            if($muestra->tecnica_id>0){
                $this->fpdf->Cell(40,6.5,utf8_decode(substr($muestra->tecnica->descripcion,0,32)),1,0,"L");
                $this->fpdf->Cell(41,6.5,utf8_decode(substr($muestra->resultado->descripcion,0,32)),1,0,"L");
            }
            else{
                $this->fpdf->Cell(40,6.5,utf8_decode(""),1,0,"C");
                $this->fpdf->Cell(41,6.5,utf8_decode(""),1,0,"C");
            }
            $fecha_lab=$muestra->fecha_llegada_lab;
            $fecha_resul=$muestra->fecha_resultado;
            $tecnico = $muestra->usuarior->name;
            $i++;
        

            $dataqr = utf8_decode($data->sedes->descripcion)." - ".utf8_decode($data->crns->descripcion)."\n";
            $dataqr .= "Ev: ".utf8_decode($data->evento->simplificado)."\n";
            $dataqr .= "Re: ".utf8_decode($data->resultado->descripcion)."\n";
            $dataqr .= "Co: ".$codigom."\n";
            $dataqr .= "Va: ".$data->usuarior_id.'-'.$data->fecha_resultado;

            QrCode::png($dataqr,storage_path('app/public/qrcodes/').$data->sedes_id.'-'.$data->crns_id.'-'.$data->anio_registro.'-'.$muestra->codigo_muestra.'.png',QR_ECLEVEL_H,3,1);

            $this->fpdf->Image(storage_path('app/public/qrcodes/').$data->sedes_id.'-'.$data->crns_id.'-'.$data->anio_registro.'-'.$muestra->codigo_muestra.'.png',171,42,28);

            

            if($muestra->crns_id==12){
                $this->fpdf->Ln(9);
                if($muestra->carga_viral>0){
                    $this->fpdf->Cell(40,6.5,utf8_decode("DETALLE CARGA VIRAL"),1,0,"C",true);
                    $this->fpdf->Cell(40,6.5,utf8_decode("Carga viral: ".$muestra->carga_viral." ".$muestra->unidades->descripcion),1,0,"L");
                    $this->fpdf->Cell(110,6.5,utf8_decode("Observaciones: ".$muestra->recomendacion_inmuno),1,0,"L");
                }
                $this->fpdf->Ln(9);
            }

            if($muestra->crns_id==6){
                $this->fpdf->Ln(9);
                if($muestra->germenaislado_mico != '' || $muestra->directokoh_mico != '' || $muestra->directoplaca_mico != '' || $muestra->tintachina_mico != ''){
                    $this->fpdf->SetFont('Arial', 'B', 7);
                    $this->fpdf->Cell(190,6,utf8_decode("Identificación de Agentes"),1,0,"C",true);
                    $this->fpdf->SetFont('Arial', '', 7);
                    $this->fpdf->Ln(6);
                    $this->fpdf->Cell(95,6,utf8_decode("Gérmen Aislado: ".$muestra->germenaislado_mico),1,0,"L");
                    $this->fpdf->Cell(95,6,utf8_decode("Directo KOH: ".$muestra->directokoh_mico),1,0,"L");
                    $this->fpdf->Ln(6);
                    $this->fpdf->Cell(95,6,utf8_decode("Placa Teñída: ".$muestra->directoplaca_mico),1,0,"L");
                    $this->fpdf->Cell(95,6,utf8_decode("Tinta China: ".$muestra->tintachina_mico),1,0,"L");
                    $this->fpdf->Ln(9);
                }
                if($muestra->deteccionunomico_id>0 || $muestra->detecciondosmico_id>0 || $muestra->detecciontresmico_id>0 || $muestra->deteccioncuatromico_id>0){
                    $this->fpdf->SetFont('Arial', 'B', 7);
                    $this->fpdf->Cell(190,6,utf8_decode("Resultados Inmunodifusión"),1,0,"C",true);
                    $this->fpdf->Ln(6);
                    $this->fpdf->Cell(95,6,utf8_decode("Detección Anticuerpo"),1,0,"C");
                    $this->fpdf->Cell(95,6,utf8_decode("Interpretación"),1,0,"C");
                    $this->fpdf->Ln(6);
                    $this->fpdf->SetFont('Arial', '', 7);

                    if($muestra->deteccionunomico_id>0){
                        $this->fpdf->Cell(95,6,utf8_decode($muestra->deteccionunomico->descripcion),1,0,"C");
                        if($muestra->interpretaunomico_id==1){
                            $this->fpdf->Cell(95,6,utf8_decode("POSITIVO"),1,0,"C");
                        }
                        else{
                            $this->fpdf->Cell(95,6,utf8_decode("NEGATIVO"),1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                    if($muestra->detecciondosmico_id>0){
                        $this->fpdf->Cell(95,6,utf8_decode($muestra->detecciondosmico->descripcion),1,0,"C");
                        if($muestra->interpretadosmico_id==1){
                            $this->fpdf->Cell(95,6,utf8_decode("POSITIVO"),1,0,"C");
                        }
                        else{
                            $this->fpdf->Cell(95,6,utf8_decode("NEGATIVO"),1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                    if($muestra->detecciontresmico_id>0){
                        $this->fpdf->Cell(95,6,utf8_decode($muestra->detecciontresmico->descripcion),1,0,"C");
                        if($muestra->detecciontresmico_id==1){
                            $this->fpdf->Cell(95,6,utf8_decode("POSITIVO"),1,0,"C");
                        }
                        else{
                            $this->fpdf->Cell(95,6,utf8_decode("NEGATIVO"),1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                    if($muestra->deteccioncuatromico_id>0){
                        $this->fpdf->Cell(95,6,utf8_decode($muestra->deteccioncuatromico->descripcion),1,0,"C");
                        if($muestra->deteccioncuatromico_id==1){
                            $this->fpdf->Cell(95,6,utf8_decode("POSITIVO"),1,0,"C");
                        }
                        else{
                            $this->fpdf->Cell(95,6,utf8_decode("NEGATIVO"),1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                }
                if($muestra->antibiogramamico_id>0){
                        $this->fpdf->SetFont('Arial', 'B', 7);
                        $this->fpdf->Cell(190,6,utf8_decode("Resultados Antibiograma"),1,0,"C",true);
                        $this->fpdf->Ln(6);
                        $this->fpdf->Cell(190,6,utf8_decode("Técnica Aplicada ".$muestra->antibiogramamico->descripcion),1,0,"C");
                        $this->fpdf->Ln(6);
                        $this->fpdf->Cell(55,6,utf8_decode("Antifúngico"),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode("CIM ug/mL"),1,0,"C");
                        $this->fpdf->Cell(55,6,utf8_decode("Difusión"),1,0,"C");
                        $this->fpdf->Cell(60,6,utf8_decode("Interpretación"),1,0,"C");
                        $this->fpdf->Ln(6);
                        $this->fpdf->SetFont('Arial', '', 7);
                        if($muestra->fungicounomico_id>0){
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->fungicounomico->descripcion),1,0,"C");
                            $this->fpdf->Cell(20,6,$muestra->cimuno_mico,1,0,"C");
                            $this->fpdf->Cell(55,6,$muestra->difusionuno_mico,1,0,"C");
                            if($muestra->escalaunomico_id==1){
                                $this->fpdf->Cell(60,6,utf8_decode("Sensible"),1,0,"C");
                            }
                            if($muestra->escalaunomico_id==2){
                                $this->fpdf->Cell(60,6,utf8_decode("Intermedio"),1,0,"C");
                            }
                            if($muestra->escalaunomico_id==3){
                                $this->fpdf->Cell(60,6,utf8_decode("Resistente"),1,0,"C");
                            }
                            if($muestra->escalaunomico_id==4){
                                $this->fpdf->Cell(60,6,utf8_decode("Punto de corte no determinado por CLSI"),1,0,"C");
                            }
                            $this->fpdf->Ln(6);
                        }
                        if($muestra->fungicodosmico_id>0){
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->fungicodosmico->descripcion),1,0,"C");
                            $this->fpdf->Cell(20,6,$muestra->cimdos_mico,1,0,"C");
                            $this->fpdf->Cell(55,6,$muestra->difusiondos_mico,1,0,"C");
                            if($muestra->escaladosmico_id==1){
                                $this->fpdf->Cell(60,6,utf8_decode("Sensible"),1,0,"C");
                            }
                            if($muestra->escaladosmico_id==2){
                                $this->fpdf->Cell(60,6,utf8_decode("Intermedio"),1,0,"C");
                            }
                            if($muestra->escaladosmico_id==3){
                                $this->fpdf->Cell(60,6,utf8_decode("Resistente"),1,0,"C");
                            }
                            if($muestra->escaladosmico_id==4){
                                $this->fpdf->Cell(60,6,utf8_decode("Punto de corte no determinado por CLSI"),1,0,"C");
                            }
                            $this->fpdf->Ln(6);
                        }
                        if($muestra->fungicotresmico_id>0){
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->fungicotresmico->descripcion),1,0,"C");
                            $this->fpdf->Cell(20,6,$muestra->cimtres_mico,1,0,"C");
                            $this->fpdf->Cell(55,6,$muestra->difusiontres_mico,1,0,"C");
                            if($muestra->escalatresmico_id==1){
                                $this->fpdf->Cell(60,6,utf8_decode("Sensible"),1,0,"C");
                            }
                            if($muestra->escalatresmico_id==2){
                                $this->fpdf->Cell(60,6,utf8_decode("Intermedio"),1,0,"C");
                            }
                            if($muestra->escalatresmico_id==3){
                                $this->fpdf->Cell(60,6,utf8_decode("Resistente"),1,0,"C");
                            }
                            if($muestra->escalatresmico_id==4){
                                $this->fpdf->Cell(60,6,utf8_decode("Punto de corte no determinado por CLSI"),1,0,"C");
                            }
                            $this->fpdf->Ln(6);
                        }
                        if($muestra->fungicocuatromico_id>0){
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->fungicocuatromico->descripcion),1,0,"C");
                            $this->fpdf->Cell(20,6,utf8_decode($muestra->cimcuatro_mico),1,0,"C");
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->difusioncuatro_mico),1,0,"C");
                            if($muestra->escalacuatromico_id==1){
                                $this->fpdf->Cell(60,6,utf8_decode("Sensible"),1,0,"C");
                            }
                            if($muestra->escalacuatromico_id==2){
                                $this->fpdf->Cell(60,6,utf8_decode("Intermedio"),1,0,"C");
                            }
                            if($muestra->escalacuatromico_id==3){
                                $this->fpdf->Cell(60,6,utf8_decode("Resistente"),1,0,"C");
                            }
                            if($muestra->escalacuatromico_id==4){
                                $this->fpdf->Cell(60,6,utf8_decode("Punto de corte no determinado por CLSI"),1,0,"C");
                            }
                            $this->fpdf->Ln(6);
                        }
                        if($muestra->fungicocincomico_id>0){
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->fungicocincomico->descripcion),1,0,"C");
                            $this->fpdf->Cell(20,6,utf8_decode($muestra->cimcinco_mico),1,0,"C");
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->difusioncinco_mico),1,0,"C");
                            if($muestra->escalacincomico_id==1){
                                $this->fpdf->Cell(60,6,utf8_decode("Sensible"),1,0,"C");
                            }
                            if($muestra->escalacincomico_id==2){
                                $this->fpdf->Cell(60,6,utf8_decode("Intermedio"),1,0,"C");
                            }
                            if($muestra->escalacincomico_id==3){
                                $this->fpdf->Cell(60,6,utf8_decode("Resistente"),1,0,"C");
                            }
                            if($muestra->escalacincomico_id==4){
                                $this->fpdf->Cell(60,6,utf8_decode("Punto de corte no determinado por CLSI"),1,0,"C");
                            }
                            $this->fpdf->Ln(6);
                        }
                        if($muestra->fungicoseismico_id>0){
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->fungicoseismico->descripcion),1,0,"C");
                            $this->fpdf->Cell(20,6,utf8_decode($muestra->cimseis_mico),1,0,"C");
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->difusionseis_mico),1,0,"C");
                            if($muestra->escalaseismico_id==1){
                                $this->fpdf->Cell(60,6,utf8_decode("Sensible"),1,0,"C");
                            }
                            if($muestra->escalaseismico_id==2){
                                $this->fpdf->Cell(60,6,utf8_decode("Intermedio"),1,0,"C");
                            }
                            if($muestra->escalaseismico_id==3){
                                $this->fpdf->Cell(60,6,utf8_decode("Resistente"),1,0,"C");
                            }
                            if($muestra->escalaseismico_id==4){
                                $this->fpdf->Cell(60,6,utf8_decode("Punto de corte no determinado por CLSI"),1,0,"C");
                            }
                            $this->fpdf->Ln(6);
                        }
                        if($muestra->fungicosietemico_id>0){
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->fungicosietemico->descripcion),1,0,"C");
                            $this->fpdf->Cell(20,6,utf8_decode($muestra->cimsiete_mico),1,0,"C");
                            $this->fpdf->Cell(55,6,utf8_decode($muestra->difusionsiete_mico),1,0,"C");
                            if($muestra->escalasietemico_id==1){
                                $this->fpdf->Cell(60,6,utf8_decode("Sensible"),1,0,"C");
                            }
                            if($muestra->escalasietemico_id==2){
                                $this->fpdf->Cell(60,6,utf8_decode("Intermedio"),1,0,"C");
                            }
                            if($muestra->escalasietemico_id==3){
                                $this->fpdf->Cell(60,6,utf8_decode("Resistente"),1,0,"C");
                            }
                            if($muestra->escalasietemico_id==4){
                                $this->fpdf->Cell(60,6,utf8_decode("Punto de corte no determinado por CLSI"),1,0,"C");
                            }
                            $this->fpdf->Ln(6);
                        }
                        $this->fpdf->Ln(3);
                }
            }

            if($muestra->crns_id==3){
                $this->fpdf->Ln(9);
                if($muestra->antibioticopsunobacte_id>0 || $muestra->antibioticopsdosbacte_id>0 || $muestra->antibioticopstresbacte_id>0 || $muestra->antibioticopscuatrobacte_id>0 || $muestra->antibioticopscincobacte_id>0){
                    $this->fpdf->SetFont('Arial', 'B', 7);
                    $this->fpdf->Cell(190,6,utf8_decode("PRUEBA DE SUSCEPTIBILIDAD: Método de Difusión (Kirby Bauer)"),1,0,"C",true);
                    $this->fpdf->Ln(6);
                    $this->fpdf->Cell(40,6,utf8_decode("ANTIBIÓTICO"),1,0,"C");
                    $this->fpdf->Cell(20,6,utf8_decode("HALO (mm.)"),1,0,"C");
                    $this->fpdf->Cell(35,6,utf8_decode("Interpretación"),1,0,"C");
                    $this->fpdf->Cell(40,6,utf8_decode("ANTIBIÓTICO"),1,0,"C");
                    $this->fpdf->Cell(20,6,utf8_decode("HALO (mm.)"),1,0,"C");
                    $this->fpdf->Cell(35,6,utf8_decode("Interpretación"),1,0,"C");
                    $this->fpdf->Ln(6);
                    $this->fpdf->SetFont('Arial', '', 7);
                    if($muestra->antibioticopsunobacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticopsunobacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->halopsuno_bacte),1,0,"C");
                        if($muestra->escalapsunobacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalapsunobacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalapsunobacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        if($muestra->antibioticopscuatrobacte_id==0){
                            $this->fpdf->Ln(6);
                        }
                    }
                    if($muestra->antibioticopscuatrobacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticopscuatrobacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->halopscuatro_bacte),1,0,"C");
                        if($muestra->escalapscuatrobacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalapscuatrobacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalapscuatrobacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                    if($muestra->antibioticopsdosbacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticopsdosbacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->halopsdos_bacte),1,0,"C");
                        if($muestra->escalapsdosbacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalapsdosbacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalapsdosbacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        if($muestra->antibioticopscincobacte_id==0){
                            $this->fpdf->Ln(6);
                        }
                    }
                    if($muestra->antibioticopscincobacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticopscincobacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->halopscinco_bacte),1,0,"C");
                        if($muestra->escalapscincobacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalapscincobacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalapscincobacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                    if($muestra->antibioticopstresbacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticopstresbacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->halopstres_bacte),1,0,"C");
                        if($muestra->escalapstresbacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalapstresbacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalapstresbacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        if($muestra->antibioticopsseisbacte_id==0){
                            $this->fpdf->Ln(6);
                        }
                    }
                    if($muestra->antibioticopsseisbacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticopsseisbacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->halopsseis_bacte),1,0,"C");
                        if($muestra->escalapsseisbacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalapsseisbacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalapsseisbacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                }
                if($muestra->antibioticomdunobacte_id>0 || $muestra->antibioticomddosbacte_id>0 || $muestra->antibioticomdtresbacte_id>0){
                    $this->fpdf->SetFont('Arial', 'B', 7);
                    $this->fpdf->Cell(190,6,utf8_decode("MÉTODO DE DILUCIÓN: CONCENTRACIÓN MINIMA INHIBITORIA"),1,0,"C",true);
                    $this->fpdf->Ln(6);
                    $this->fpdf->Cell(40,6,utf8_decode("ANTIBIÓTICO"),1,0,"C");
                    $this->fpdf->Cell(20,6,utf8_decode("CIM (μg/mL.)"),1,0,"C");
                    $this->fpdf->Cell(35,6,utf8_decode("Interpretación"),1,0,"C");
                    $this->fpdf->Cell(40,6,utf8_decode("ANTIBIÓTICO"),1,0,"C");
                    $this->fpdf->Cell(20,6,utf8_decode("CIM (μg/mL.)"),1,0,"C");
                    $this->fpdf->Cell(35,6,utf8_decode("Interpretación"),1,0,"C");
                    $this->fpdf->Ln(6);
                    $this->fpdf->SetFont('Arial', '', 7);
                    if($muestra->antibioticopsunobacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticomdunobacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->cimmduno_bacte),1,0,"C");
                        if($muestra->escalamdunobacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalamdunobacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalamdunobacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        if($muestra->antibioticomddosbacte_id==0){
                            $this->fpdf->Ln(6);
                        }
                    }
                    if($muestra->antibioticopsdosbacte_id>0){
                        $this->fpdf->Cell(40,6,utf8_decode($muestra->antibioticomddosbacte->descripcion),1,0,"C");
                        $this->fpdf->Cell(20,6,utf8_decode($muestra->cimmddos_bacte),1,0,"C");
                        if($muestra->escalamddosbacte_id==1){
                            $this->fpdf->Cell(35,6,"Sensible",1,0,"C");
                        }
                        if($muestra->escalamddosbacte_id==2){
                            $this->fpdf->Cell(35,6,"Intermedio",1,0,"C");
                        }
                        if($muestra->escalamddosbacte_id==3){
                            $this->fpdf->Cell(35,6,"Resistente",1,0,"C");
                        }
                        $this->fpdf->Ln(6);
                    }
                }
                $this->fpdf->Ln(6);
            }

        }

        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,6.5,utf8_decode("Detalle del Resultado"),1,0,"C",true);
        $this->fpdf->Ln(6.5);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(190,6.5,utf8_decode("Evento: ".substr($data->evento->descripcion,0,75)." - (".$data->evento->simplificado.")"),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(190,6.5,utf8_decode("Resultado: ".$data->resultado->descripcion),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Cell(190,6.5,utf8_decode("Descripción del resultado encontrado:"),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Cell(190,23,"",1,0,"L");
        $this->fpdf->Ln(1);
        $countwords = strlen($data->descripcion);
        $texto = $data->descripcion;
        $lineas = 0;
        $arriba = '';
        $abajo = '';
        if($countwords>160){
            while($countwords>160){
                $control = stripos($texto, ' ');
                $arriba = substr($texto, 0, $control);
                $abajo = substr($texto, $control+1, $countwords);
                while($control<160){
                    $paso = $control+1;
                    $control = stripos($abajo, ' ');
                    $arriba = $arriba.' '.substr($abajo, 0, $control);
                    $abajo = substr($abajo, $control+1, $countwords);
                    $control = $control + $paso;
                    if($control>155){
                        $control = $control + 20;
                    }
                }
                $this->fpdf->cell(190,5.5,utf8_decode($arriba),0,0,"L");
                $this->fpdf->Ln(5.5);
                $countwords = $countwords - strlen($arriba);
                $texto = $abajo;
                $lineas++;
            }
            $this->fpdf->cell(190,5.5,utf8_decode($abajo),0,0,"L");
        }
        else{
            $this->fpdf->cell(190,5.5,utf8_decode($data->descripcion),0,0,"L");
        }


        $this->fpdf->Ln(27);
        $this->fpdf->SetFont('Arial', 'B', 7);
        $this->fpdf->Cell(90,6.5,utf8_decode("Trazabilidad del proceso"),1,0,"C",true);
        $this->fpdf->SetFont('Arial', '', 7);
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(90,6.5,utf8_decode("Recepción muestra: ".$data->usuariot->name.' ('.$data->fecha_recepcion.')'),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(90,6.5,utf8_decode("Llegada al CRN - Laboratorio : ".$fecha_lab),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(90,6.5,utf8_decode("Analítica: ".$tecnico.' ('.$fecha_resul.')'),1,0,"L");
        $this->fpdf->Ln(6.5);
        $this->fpdf->Cell(90,6.5,utf8_decode("Validación resultado: ".$data->usuarior->name.' ('.$data->fecha_resultado.')'),1,0,"L");
        $this->fpdf->Ln(6.5);

        $this->fpdf->Output();
        exit;
    }

    public function generar_ampliada(Request $request){
        dd($request);
        $c = $request->eventosav_id;
        dd($c); die();
    }

}
