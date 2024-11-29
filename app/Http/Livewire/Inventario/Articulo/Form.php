<?php

namespace App\Http\Livewire\Inventario\Articulo;

use App\Models\User;
use App\Models\RecursosHumanos\Sede;
use App\Models\Inventario\Edificio;
use App\Models\Inventario\Sector;
use App\Models\Inventario\Clase;
use App\Models\Inventario\Marca;
use App\Models\Inventario\Origen;
use App\Models\Inventario\Estado;
use App\Models\Inventario\Articulo;
use Livewire\Component;

class Form extends Component
{
    public $method;
    public $Articulos;

    public $selectedArea = null;

    protected function rules()
    {
        return [
            'Articulos.nombre' => 'required|max:150',
            'Articulos.caracteristicas' => 'required|max:850',
            'Articulos.codigoinventario' => 'required|max:50',
            'Articulos.codigoebye' => 'required|max:50',
            'Articulos.modelo' => 'required|max:75',
            'Articulos.serie' => 'required|max:75',
            'Articulos.color' => 'required|max:75',
            'Articulos.fechacompra' => 'required|max:10',
            'Articulos.valorcompra' => 'required|numeric',
            'Articulos.factura' => 'required|max:50',
            'Articulos.cur' => 'required|max:50',
            'Articulos.valorlibros' => 'required|numeric',
            'Articulos.depreciacion' => 'required|numeric',
            'Articulos.sede_id' => 'required|numeric',
            'Articulos.edificio_id' => 'required|numeric',
            'Articulos.sector_id' => 'required|numeric',
            'Articulos.clase_id' => 'required|numeric',
            'Articulos.marca_id' => 'required|numeric',
            'Articulos.origen_id' => 'required|numeric',
            'Articulos.estado_id' => 'required|numeric',
            'Articulos.custodio_id' => 'required|numeric',
            'Articulos.usuario_id' => 'required|numeric',
        ];
    }

    public function mount(Articulo $Articulos, $method){
        $this->Articulos = $Articulos;
        $this->method = $method;
    }

    public function render()
    {
        $sedes = Sede::orderBy('id', 'asc')->cursor();
        $edificios = Edificio::orderBy('id', 'asc')->cursor();
        $sectores = Sector::orderBy('id', 'asc')->cursor();
        $clases = Clase::orderBy('id', 'asc')->cursor();
        $marcas = Marca::orderBy('id', 'asc')->cursor();
        $estados = Estado::orderBy('id', 'asc')->cursor();
        $origenes = Origen::orderBy('id', 'asc')->cursor();
        $users = User::orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.inventario.articulo.form',compact('sedes','edificios','sectores','clases','marcas','estados','origenes','users'));
    }

    /*
    public function updatedselectedArea($area_id){
        $this->direcciones = Direccion::where('area_id','=',$area_id)->orderBy('id', 'asc')->get();
    }
    */
    public function store(){
        $this->validate();
        $this->Articulos->estadoregistro='A';
        $this->Articulos->save();
        $this->Articulos = new Articulo();
        $this->alert('success', 'Artículo agregado con exito');
        $this->emit('render');
        return view('livewire.inventario.articulo.index');
    }

    public function storeCustom(){
        $this->validate();
        $this->Articulos->save();
        $this->Articulos = new Articulo();
        $this->alert('success', 'Artículo agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Articulos->update();
        $this->alert('success', 'Artículo modificado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }
}
