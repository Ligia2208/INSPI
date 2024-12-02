<?php

namespace App\Http\Livewire\Seguimiento;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Exception;
use App\Models\User;
use App\Models\RecursosHumanos\Filiacion;
use App\Models\GestionDocumental\Asignacion;
use App\Models\GestionDocumental\Seguimiento;
use App\Models\GestionDocumental\Comunicacion;
use App\Models\CoreBase\Area;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
//use Jantinnerezo\LivewireAlert\LivewireAlert;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    //use LivewireAlert;

    public $userPresent;
    public $filiacion;
    public $area;
            
    //Tools
    public $perPage = 10;
    public $search;
    protected $queryString = ['search' => ['except' => '']];   

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->userPresent = User::find(Auth::user()->id);
        $this->filiacion = Filiacion::where('user_id', '=', Auth::user()->id)->firstOrFail();
        $this->area = $this->filiacion->area_id;
        $this->cargo = $this->filiacion->cargo_id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {           
        $count = Asignacion::where('procesado','=',0)->count();
        $Seguimientos = Asignacion::where('procesado','=',0)->orderBy('id','desc');       
        
        if($this->search){
            $Seguimientos = $Seguimientos->where('numerodocumento', 'LIKE', "%{$this->search}%")->orwhere('referencia', 'LIKE', "%{$this->search}%");
            $count = $Seguimientos->where('numerodocumento', 'LIKE', "%{$this->search}%")->orwhere('referencia', 'LIKE', "%{$this->search}%")->count();
        }
        $Seguimientos = $Seguimientos->paginate($this->perPage);
        return view('livewire.gestiondocumental.seguimiento.index', compact('count', 'Seguimientos'));
    }

    public function destroy($id)
    {
        $correoprincipal = '';
        $correoasistente = '';
        $documento = '';
        $referencia = '';
        $remitente = '';
        $fecha = '';
        $asunto = '';
        $alertas = 0;
        $Seguimientos = Asignacion::where('id','=',$id)->get();
        $documento = $Seguimientos[0]->numerodocumento;
        $referencia = $Seguimientos[0]->referencia;
        $remitente = $Seguimientos[0]->remitente;
        $fecha = $Seguimientos[0]->fechaasignacionde;
        $asunto = $Seguimientos[0]->descripcion;
        $alertas = $Seguimientos[0]->alertas;
        $correos = Comunicacion::where('area_id','=',$Seguimientos[0]->area_id)->get();
        $correoprincipal = $correos[0]->correo_principal;
        $correoasistente = $correos[0]->correo_asistente;
        $alertas = $alertas + 1;
        $SegAct = Seguimiento::findOrFail($id);
        $SegAct->alertas = $alertas;
        $SegAct->update();
        try{
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'mail.inspi.gob.ec';
            $mail->SMTPAuth = true;
            $mail->Username = 'soporte_tics@inspi.gob.ec';
            $mail->Password = '@dminINSPI2022';
            $mail->SMTPSecure = 'tls';
            $mail->Port=587;
            $mail->Timeout=300;
            $mail->setFrom('soporte_tics@inspi.gob.ec');
            $mail->addAddress($correoprincipal);
            $mail->addAddress($correoasistente);
            $mail->Subject = 'Notificación INSPI - Documento Pendiente';
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Body = '<html>
                           <head>
                           <style>
                                .contenedor{
                                    position: relative;
                                    display: inline-block;
                                    text-align: center;
                                }                
                                .centrado{
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                }
                            </style>
                            </head>
                            <body> 
                                <div class="contenedor">
                                <h3><p>Se genera esta alerta por cuanto, se encuentra pendiente respuesta al documento '.$documento.' con asunto: "'.$asunto.'" cuya fecha máxima de contestación es '.$fecha.', sírvase coordinar las acciones necesarias para atender oportunamente este requerimiento.</p></h3>
                                <h3><p></p></h3>
                                <h3><p>Este correo se envia como una alerta de actividad desde el CoreInspi</p></h3>
                                <div class="centrado">
                            </body>
                            </html>'; 

            $mail->Send(); 
                     
            
        }
        catch (Exception $e){
            $this->alert('error', 'Correo no enviado');
        }
        $this->alert('success', 'Notificación enviada');
        session()->flash('alert-type', 'success');
    }
}
