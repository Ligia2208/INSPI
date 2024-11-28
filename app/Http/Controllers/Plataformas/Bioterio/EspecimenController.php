<?php

namespace App\Http\Controllers\Plataformas\Bioterio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Plataformas\Especimen;

class EspecimenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:especimenes']);
    }

    public function index(){
        return view('plataformas.especimen.index');
    }

    public function ficha($id){
        $especimen = Especimen::findOrFail($id);

        $this->fpdf = new Fpdf;
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->AddPage("P", "A4");
        $this->fpdf->Image('descarga.png',9,21,-180);
        $this->fpdf->Cell(50, 40, "",1,0,"C");
        $this->fpdf->Cell(80, 20, "", 1);
        $this->fpdf->Text(90,18,utf8_decode("FICHA MÉDICA"));
        $this->fpdf->Text(78,24,utf8_decode("CONTROL DE ESPECÍMENES"));
        $this->fpdf->Cell(30, 10, utf8_decode("Código:"),1,0,"C");
        $this->fpdf->Cell(30, 10, "F-BIO-0022",1,0,"C");
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(130,10,"",0,0,"C");
        $this->fpdf->Cell(30, 10, utf8_decode("Edición"),1,0,"C");
        $this->fpdf->Cell(30, 10, "003",1,0,"C");
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(50,20,"",0,0,"C");
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Text(71,37,"Macro-Proceso");
        $this->fpdf->Text(73,41,"Plataformas");
        $this->fpdf->Text(73,45,"Compartidas");
        $this->fpdf->Cell(40, 20, "",1);
        $this->fpdf->Cell(40, 20, "",1,0,"C");
        $this->fpdf->Text(110,39,"Proceso Interno");
        $this->fpdf->Text(116,43,utf8_decode("Bioterio"));
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 20, utf8_decode("Fecha Aprobación"),1,0,"C");
        $this->fpdf->Cell(30, 20, "01/04/2022",1,0,"C");
        $this->fpdf->Ln(20);

        //------------------------------------------------------------------------
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(60, 8, utf8_decode("Fecha de Nacimiento / Admisión:"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(130, 8, utf8_decode($especimen->nacimiento_admision.' - '.$especimen->ubicacion),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(40, 8, utf8_decode("Procedencia"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(150, 8, utf8_decode($especimen->procedencia),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(40, 8, utf8_decode("Veterinario encargado"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(150, 8, utf8_decode($especimen->veterinario),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(190,8,utf8_decode("1.- Reseña"),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Especie"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->especie->nombre),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Sexo"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->sexo->nombre),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Edad"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(40, 8, utf8_decode($especimen->edad.' años'),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Peso"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->peso.' Kg.'),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Color"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->color),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Código / Nombre"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(40, 8, utf8_decode($especimen->codigo_nombre),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(50, 8, utf8_decode("Señas particulares"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(140, 8, utf8_decode($especimen->marcas_particulares),1,0,"L");
        $this->fpdf->Ln(8);

        //------------------------------------------------------------------------
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(190, 8, utf8_decode("2.- Historia"),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(95, 8, utf8_decode("Vacunación:"),1,0,"C");
        $this->fpdf->Cell(95, 8, utf8_decode("Desparasitación:"),1,0,"C");
        $this->fpdf->Ln(8);
        $this->fpdf->Cell(95,50,"",1,0,"C");
        $this->fpdf->Cell(95,50,"",1,0,"C");
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Text(41,126,"Producto utilizado/fecha");
        $this->fpdf->Text(136,126,"Producto utilizado/fecha");
        $this->fpdf->Ln(50);

        //------------------------------------------------------------------------
        $this->fpdf->Cell(190,8,"3.- Dietas",1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->Cell(190,22,"",1,0,"C");
        $this->fpdf->Ln(22);

        //------------------------------------------------------------------------
        $this->fpdf->Cell(190,8,utf8_decode("4.- Constantes Fisiológicas"),1,0,"C");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Pulso"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->especie->nombre),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Temperatura"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->sexo->nombre),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Mucosas"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(40, 8, utf8_decode($especimen->edad.' años'),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("FC"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->peso.' Kg.'),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("FR"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(30, 8, utf8_decode($especimen->color),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("T.L.C."),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(40, 8, utf8_decode($especimen->codigo_nombre),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Turgencia Piel"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(40, 8, utf8_decode($especimen->peso.' Kg.'),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 8, utf8_decode("Propósito"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(90, 8, utf8_decode($especimen->color),1,0,"L");
        $this->fpdf->Ln(8);

        //------------------------------------------------------------------------
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(55, 8, utf8_decode("Intervencios Quirúrgicas"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(40, 8, utf8_decode($especimen->peso.' Kg.'),1,0,"L");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(55, 8, utf8_decode("Alergías"),1,0,"L");
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(40, 8, utf8_decode($especimen->color),1,0,"L");
        $this->fpdf->Ln(8);

        //------------------------------------------------------------------------
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(190,8,utf8_decode("5.- Anamnésis/Historia o Antecedentes"),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->Cell(190,26,"",1,0,"C");
        $this->fpdf->Ln(40);

        //------------------------------------------------------------------------
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(190,8,utf8_decode("6.- Manifestaciones Clínicas"),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->Cell(190,30,"",1,0,"C");
        $this->fpdf->Ln(30);

        //------------------------------------------------------------------------
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(190,8,utf8_decode("7.- Tratamientos"),1,0,"L");
        $this->fpdf->Ln(8);
        $this->fpdf->Cell(190,50,"",1,0,"C");
        $this->fpdf->Ln(50);
        $this->fpdf->Output();
        exit;
    }

}
