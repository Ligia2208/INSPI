<?php

namespace App\Http\Controllers\Inventario\Articulo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario\Articulo;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\User;
use App\Models\Inventario\Participante;

class ArticuloController extends Controller
{
    protected $fpdf;
    
    public function __construct()
    {
        $this->middleware(['permission:articulos']);
    }

    public function index(){
        return view('inventario.articulo.index');
    }

    public function create(){
        $articulo = new Articulo();
        return view('inventario.articulo.create', compact('articulo'));
    }

    public function show(Articulo $articulo){
        return view('inventario.articulo.show', compact('articulo'));
    }

    public function edit(Articulo $articulo){
        return view('inventario.articulo.edit', compact('articulo'));
    }

    public function listado($id){
        $articulos = Articulo::where('id','=',$id)->firstOrFail();
        $participantes = Participante::where('estado','=','A')->firstOrFail();
        $custodio = User::where('id','=',$articulos->custodio_id)->firstOrFail();
        $usuario = User::where('id','=',$articulos->usuario_id)->firstOrFail();
        $principal = User::where('id','=',$participantes->principal_id)->firstOrFail();
        $guarda = User::where('id','=',$participantes->guardaalmacen_id)->firstOrFail();
        $analista = User::where('id','=',$participantes->analista_id)->firstOrFail();
        $administrativo = User::where('id','=',$participantes->administrativo_id)->firstOrFail();
        $count = Articulo::where('id','=',$id)->count();
        $this->fpdf = new Fpdf;
        $this->fpdf->AddPage("P", "A4");
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Image('descargar.png',9,21,-180);
        $this->fpdf->Cell(50, 40, "",1,0,"C");           
        $this->fpdf->Cell(80, 20, "", 1); 
        $this->fpdf->Text(75,18,"ACTA DE ENTREGA - RECEPCION");
        $this->fpdf->Text(85,24,"DE BIENES - MUEBLES");
        $this->fpdf->Cell(30, 10, utf8_decode("Código:"),1,0,"C");
        $this->fpdf->Cell(30, 10, "F-GADM-004",1,0,"C");
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(130,10,"",0,0,"C");
        $this->fpdf->Cell(30, 10, utf8_decode("Edición"),1,0,"C");
        $this->fpdf->Cell(30, 10, "005",1,0,"C");
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(50,20,"",0,0,"C");
        $this->fpdf->SetFont('Arial', 'B', 8);
        $this->fpdf->Text(72,37,"Macro-Proceso");
        $this->fpdf->Text(66,41,utf8_decode("Dirección de Gestión"));
        $this->fpdf->Text(62,45,utf8_decode("Administrativa - Financiera"));
        $this->fpdf->Cell(40, 20, "",1);
        $this->fpdf->Cell(40, 20, "",1,0,"C");
        $this->fpdf->Text(110,37,"Proceso Interno");
        $this->fpdf->Text(116,41,utf8_decode("Gestión"));
        $this->fpdf->Text(111,45,utf8_decode("Administrativa"));
        $this->fpdf->SetFont('Arial', 'B', 9);
        $this->fpdf->Cell(30, 20, utf8_decode("Fecha Aprobación"),1,0,"C");
        $this->fpdf->Cell(30, 20, "28/03/2019",1,0,"C");
        $this->fpdf->Ln(20);
        $this->fpdf->Cell(190, 10, "Acta No. 331/$participantes->periodo",0,0,"R");
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->Cell(190, 10, utf8_decode("En la Ciudad de Guayaquil, a los 27 días del mes de Noviembre de 2021, comparecen:"),0,0,"L");
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(190, 10, utf8_decode("1.- $custodio->name, $custodio->position (Custodio Administrativo)"),0,0,"L");
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(190, 10, utf8_decode("2.- $principal->name, Jefe de Inventarios (Inventarios)"),0,0,"L");
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(190, 10, utf8_decode("3.- $guarda->name, $guarda->position (Inventarios)"),0,0,"L");
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(190, 10, utf8_decode("4.- $analista->name, $analista->position (Inventarios)"),0,0,"L");
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(190, 10, utf8_decode("5.- $administrativo->name, $administrativo->position (Administrativo Financiero)"),0,0,"L");
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(190, 10, utf8_decode("6.- $usuario->name, $usuario->position (Usuario Final)"),0,0,"L"); 
        $this->fpdf->Ln(12);

        $this->fpdf->MultiCell(190, 6, utf8_decode("Los  mismos  comparecientes  quienes, en  cumplimiento  de las  Normas de Control  Interno  de  la  Contraloría  General  del  Estado. 406-01-Unidad  de Administración  de Bienes, y 406-07-Custodia y en  concordancia con  el  Reglamento  General  Sustitutivo para la Administración, Utilización, Manejo y Control  de  los  Bienes e  Inventarios del Sector Público, de la Contraloría  General  del  Estado, publicado en Registro  Oficial  Suplemento 388 el 14 de diciembre de 2018, en el Art.42.-Entrega Recepción de Bienes entre distintas entidades u organismos; Art.43.- Delegación  de  la  Máxima  Autoridad, Art.44.- Procedimiento de entrega de bienes  y/o  inventarios, suscriben la presente ACTA DE ENTREGA - RECEPCIÓN de bienes muebles, según detalle a continuación:"));
        $this->fpdf->Ln(12);

        $this->fpdf->Cell(7, 6, "No.",1,0,"C");
        $this->fpdf->Cell(37, 6, utf8_decode("Código Inventario"),1,0,"C");
        $this->fpdf->Cell(26, 6, utf8_decode("Código Ebye"),1,0,"C");
        $this->fpdf->Cell(20, 6, utf8_decode("Marca"),1,0,"C");
        $this->fpdf->Cell(20, 6, utf8_decode("Modelo"),1,0,"C");
        $this->fpdf->Cell(28, 6, utf8_decode("Serie"),1,0,"C");
        $this->fpdf->Cell(18, 6, utf8_decode("Color"),1,0,"C");
        $this->fpdf->Cell(18, 6, utf8_decode("Estado"),1,0,"C");
        $this->fpdf->Cell(16, 6, utf8_decode("En libros"),1,0,"C");
       
        for($i=0; $i<$count; $i++){
            $this->fpdf->Ln(6);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(7, 6, $x_axis, $i+1,0);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(37, 6, $x_axis, utf8_decode($articulos->codigoinventario),20);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(26, 6,  $x_axis, utf8_decode($articulos->codigoebye),0);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(20, 6,  $x_axis, utf8_decode($articulos->marca->descripcion),0);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(20, 6, $x_axis, utf8_decode($articulos->modelo),0);
            
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(28, 6,  $x_axis, utf8_decode($articulos->serie),0);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(18, 6,  $x_axis, utf8_decode($articulos->color),0);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(18, 6,  $x_axis, utf8_decode($articulos->estado->descripcion),0);
            $x_axis=$this->fpdf->getx();
            $this->fpdf->vcell(16, 6,  $x_axis, $articulos->valorlibros,0);

        }

        $this->fpdf->Ln(12);
        $this->fpdf->Cell(190, 10, utf8_decode("Por la presente se deja constancia de la conformidad en cuanto a la entrega y recepción de los bienes muebles."),0,0,"L"); 
        $this->fpdf->Ln(12);
        $this->fpdf->MultiCell(190, 6, utf8_decode("OBSERVACIONES: Esta constatación física corresponde al periodo $participantes->periodo, según cronograma aprobado por  la Máxima  Autoridad. Esta Acta hace referencia a los Bienes de la Dirección General de Planificación y Gestión Estratégica.")); 

        $this->fpdf->Ln(30);
        $this->fpdf->Cell(95, 10, utf8_decode("Entrega:"),0,0,"C"); 
        $this->fpdf->Cell(95, 10, utf8_decode("Recibe"),0,0,"C");
        $this->fpdf->Ln(20);
        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C"); 
        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C");
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($custodio->name),0,0,"C"); 
        $this->fpdf->Cell(95, 10, utf8_decode($usuario->name),0,0,"C");
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($custodio->position),0,0,"C"); 
        $this->fpdf->Cell(95, 10, utf8_decode($usuario->position),0,0,"C");
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode("Custodio Administrativo de Bienes"),0,0,"C"); 
        $this->fpdf->Cell(95, 10, utf8_decode("Usuario Final"),0,0,"C");
        $this->fpdf->Ln(25);

        if ($this->fpdf->getY()>270){
            $this->fpdf->AddPage("P", "A4");
            $this->fpdf->Image('descargar.png',9,21,-180);
            $this->fpdf->Cell(50, 40, "",1,0,"C");           
            $this->fpdf->Cell(80, 20, "", 1); 
            $this->fpdf->Text(75,18,"ACTA DE ENTREGA - RECEPCION");
            $this->fpdf->Text(85,24,"DE BIENES - MUEBLES");
            $this->fpdf->Cell(30, 10, utf8_decode("Código:"),1,0,"C");
            $this->fpdf->Cell(30, 10, "F-GADM-004",1,0,"C");
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(130,10,"",0,0,"C");
            $this->fpdf->Cell(30, 10, utf8_decode("Edición"),1,0,"C");
            $this->fpdf->Cell(30, 10, "005",1,0,"C");
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(50,20,"",0,0,"C");
            $this->fpdf->SetFont('Arial', 'B', 8);
            $this->fpdf->Text(72,37,"Macro-Proceso");
            $this->fpdf->Text(66,41,utf8_decode("Dirección de Gestión"));
            $this->fpdf->Text(62,45,utf8_decode("Administrativa - Financiera"));
            $this->fpdf->Cell(40, 20, "",1);
            $this->fpdf->Cell(40, 20, "",1,0,"C");
            $this->fpdf->Text(110,37,"Proceso Interno");
            $this->fpdf->Text(116,41,utf8_decode("Gestión"));
            $this->fpdf->Text(111,45,utf8_decode("Administrativa"));
            $this->fpdf->SetFont('Arial', 'B', 9);
            $this->fpdf->Cell(30, 20, utf8_decode("Fecha Aprobación"),1,0,"C");
            $this->fpdf->Cell(30, 20, "28/03/2019",1,0,"C");
            $this->fpdf->Ln(20);
            $this->fpdf->Cell(190, 10, "Acta No. 331/$participantes->periodo",0,0,"R");
            $this->fpdf->Ln(25);
        } 
        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C");
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($administrativo->name),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($administrativo->position),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode("Responsable Administrativo Financiero"),0,0,"C"); 
        $this->fpdf->Ln(25);

        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C");
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($principal->name),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($principal->position),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode("Jefe Inventarios"),0,0,"C"); 
        $this->fpdf->Ln(25);

        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C");
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($guarda->name),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($guarda->position),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode("Guarda Almacén (Inventarios)"),0,0,"C"); 
        $this->fpdf->Ln(25);

        $this->fpdf->Cell(95, 10, "________________________________",0,0,"C");
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($analista->name),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode($analista->position),0,0,"C"); 
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(95, 10, utf8_decode("Analista Administrativo (Inventarios)"),0,0,"C"); 
        $this->fpdf->Ln(25);

        $this->fpdf->Output();
        exit;
    }

}
