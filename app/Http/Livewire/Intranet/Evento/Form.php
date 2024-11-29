<?php

namespace App\Http\Livewire\Evento;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Mail\MensajeEnviado;
use App\Models\CoreBase\Area;
use App\Models\Intranet\Evento;
use App\Models\Intranet\Tipoinforme;
use App\Models\Intranet\Tipoactividad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Form extends Component
{

    use WithFileUploads;
    
    public $method;
    public $quotation;

    //Tools
    public $EventoTmp;
    public $Origenes;
    public $Dependencias;
    public $Eventos;
    public $Areas;
    public $selectedOrigen = null;
    
    protected $listeners = ['render'];

    protected function rules()
    {
        
        return [
            'Eventos.area_id' => 'required|numeric',
            'Eventos.tipoactividad_id' => 'required|numeric',
            'Eventos.tipoinforme_id' => 'required|numeric',
            'Eventos.nombreactividad' => 'required|max:500',
            'Eventos.fechaevento' => 'required',
            'Eventos.horaevento' => 'required',
            'Eventos.lugar' => 'required|max:175',
            'Eventos.resumen' => 'sometimes|max:1000',
            'Eventos.participantes' => 'sometimes|max:500',
            'Eventos.comentarios' => 'sometimes|max:1000',
            'Eventos.responsables' => 'sometimes|max:250',
        ];
    }

    public function mount(Evento $Evento, $method){
        $this->Eventos = $Evento;
        $this->method = $method;
        
    }

    public function render()
    {
        $tiposactividad = Tipoactividad::orderBy('id', 'asc')->cursor();
        $tiposinforme = Tipoinforme::orderBy('id', 'asc')->cursor();
        $areas = Area::orderBy('id', 'asc')->cursor();
        
        $this->emit('renderJs');
        return view('livewire.intranet.evento.form', compact('areas','tiposactividad','tiposinforme'));
    }


    public function store(){
        
        $this->validate();

        $this->Eventos->estado='A';
        $this->Eventos->whatsapp=0;
        $this->Eventos->facebook=0;
        $this->Eventos->twitter=0;
        $this->Eventos->instagram=0;
        $this->Eventos->correo=0;
        $this->Eventos->web=0;
        $this->Eventos->cerrado=0;
        $this->Eventos->usuario_id=Auth::user()->id;
        $this->Eventos->save();

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
            $mail->addAddress('comunicacionsocial@inspi.gob.ec');
            $mail->addAddress('jchavez@inspi.gob.ec');
            $mail->addAddress('jmero@inspi.gob.ec');
            $mail->Subject = 'Registro Comunicación - Nueva Actividad';
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
                                <h3><p>Se ha generado una nueva actividad, sirvase revisar la aplicación para coordinar las acciones necesarias.</p></h3>
                                <h3><p> Actividad: '.$this->Eventos->nombreactividad.'<br> Resumen: '.$this->Eventos->resumen.' <br> Generada desde área/gestión: '.$this->Eventos->area->nombre.'</p></h3>
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

        session()->flash('alert', 'Evento agregado');
        session()->flash('alert-type', 'success');
        
        return redirect()->route('evento.index');
    }

    public function update(){
        $this->validate();
        $this->Eventos->update();
        session()->flash('alert', 'Solicitud actualizada con exito');
        session()->flash('alert-type', 'success');
        return redirect()->route('evento.index');
    }


    public function saveEvento(){
        
        if($this->EventoTmp){
            if(Storage::exists($this->Eventos->archivo)){
                Storage::delete($this->Eventos->archivo);
            }
            
            $path = $this->EventoTmp->store('public/eventos/inspi');
            $this->Eventos->archivo = $path;
        }
    }

    public function removeEvento(){
        if($this->Eventos->archivo){
            if(Storage::exists($this->Eventos->archivo)){
                Storage::delete($this->Eventos->archivo);
            }
            
            $this->Eventos->archivo = null;
            $this->Eventos->update();
        }
        $this->reset('EventoTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
