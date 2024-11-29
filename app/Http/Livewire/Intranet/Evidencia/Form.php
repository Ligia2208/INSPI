<?php

namespace App\Http\Livewire\Evidencia;

use App\Models\Intranet\Evidencia;
use App\Models\Intranet\Tipoevidencia;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Form extends Component
{   
    use WithFileUploads;
    public $method;
    public $evento_id;
    public $Evidencias;
    public $EvidenciaTmp;
    public $EventoTmp;

    protected function rules()
    {
        return [
            'Evidencias.descripcion' => 'required|max:175',
            'Evidencias.tipoevidencia_id' => 'required|numeric',
            'Evidencias.evento_id' => 'required|numeric',
        ];
    }

    public function mount(Evidencia $Evidencias, $method){
        $this->Evidencias = $Evidencias;
        $this->method = $method;

    }

    public function render()
    {
        $tiposevidencia = Tipoevidencia::orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.intranet.evidencia.form', compact('tiposevidencia'));
    }

    public function store(){
        $this->validate();
        $this->validate([
            'EvidenciaTmp' => 'required',
        ]);
        $this->saveEvidencia();
        $this->Evidencias->save();
        $ev_id = $this->Evidencias->evento_id;
        $this->Evidencias = new Evidencia();
        $this->alert('success', 'Evidencia agregada con exito');
        $this->reset('EvidenciaTmp');
        return redirect()->route('evidencia.show', $ev_id);
    }

    public function storeCustom(){
        $this->validate();
        $this->Evidencias->save();
        $ev_id = $this->Evidencias->evento_id;
        $this->Evidencias = new Evidencia();
        $this->alert('success', 'Evidencia agregado con exito');
        $this->reset('EvidenciaTmp');
        return redirect()->route('evidencia.show',$ev_id);
    }

    public function update(){
        $this->validate();
        $this->saveEvidencia();
        $this->Evidencias->update();
        $this->emit('render');
        $this->alert('success', 'Evidencia modificado con exito');
        $this->reset('EvidenciaTmp');
        $this->emit('closeModal');
    }

    public function saveEvidencia(){
        if($this->EvidenciaTmp){
            if(Storage::exists($this->Evidencias->archivo)){
                Storage::delete($this->Evidencias->archivo);
            }
            
            $path = $this->EvidenciaTmp->store('public/evidencias/inspi');
            $path = substr($path, 7); 
            $this->Evidencias->archivo = $path;
        }
    }

    public function removeEvidencia(){
        if($this->Evidencias->archivo){
            if(Storage::exists($this->Evidencias->archivo)){
                Storage::delete($this->Evidencias->archivo);
            }
            
            $this->Evidencias->archivo = null;
            $this->Evidencias->update();
        }
        $this->reset('EvidenciaTmp');
        $this->alert('success', 'Archivo digitalizao eliminado con exito');
    }
}
