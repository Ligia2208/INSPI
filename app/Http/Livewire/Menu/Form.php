<?php

namespace App\Http\Livewire\Menu;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Menu;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    public $method;
    public $Areas;
    public $Menues;

    protected function rules()
    {
        return [
            'Menues.padre_id' => 'required',
            'Menues.titulo' => 'required|max:175',
            'Menues.descripcion' => 'required|max:250',
            'Menues.ruta' => 'required|max:250',
            'Menues.permiso' => 'required|max:125',
            'Menues.tipo' => 'max:25',
            'Menues.icono' => 'max:250',
        ];
    }

    public function mount(Menu $Menues, $method){
        $this->Menues = $Menues;
        $this->method = $method;
    }

    public function render()
    {
        $menus = Menu::orderBy('id','asc')->where('tipo', 'MENU')->whereIn('estado',['A','O'])->cursor();
        $areas = Area::orderBy('id', 'asc')->cursor();
        $this->emit('renderJs');
        return view('livewire.corebase.menu.form',compact('areas','menus'));
    }

    public function store(){

        $this->validate();
        $newMenuId = 0;
        $newOrdenId = '';
        if ($this->Menues->padre_id==0){
            $menuLast = Menu::orderBy('nivel_id','asc')->select('nivel_id')
            ->where('tipo', 'MENU')
            ->get();

            foreach ($menuLast as $item) {
                $newMenuId = $item->nivel_id;
            }

            if($newMenuId==0 || $newMenuId==''){
                $newMenuId=1;
            }else{
                $newMenuId++;
            }
            $this->Menues->icono='fa fa-university';
            $this->Menues->tipo='MENU';
            $this->Menues->nivel_id=$newMenuId;
            $this->Menues->orden='0.'.$newMenuId;
        }
        else{
            $menuLast = Menu::orderBy('nivel_id','asc')->select('nivel_id')
            ->where('padre_id',$this->Menues->padre_id)
            ->where('tipo', 'MENUITEM')
            ->get();

            foreach ($menuLast as $item) {
                $newMenuId = $item->nivel_id;
            }

            if($newMenuId==0 || $newMenuId==''){
                $newMenuId=1;
            }else{
                $newMenuId++;
            }

            $ordenLast = Menu::orderBy('orden','asc')->select('orden')
            ->where('padre_id','0')
            ->where('nivel_id',$this->Menues->padre_id)
            ->where('tipo', 'MENU')
            ->get();

            foreach ($ordenLast as $item) {
                $newOrdenId = $item->orden;
            }

            $this->Menues->nivel_id=$newMenuId;
            $this->Menues->orden=$newOrdenId.'.'.$newMenuId;
            $this->Menues->tipo='MENUITEM';
        }

        $this->Menues->estado='A';
        $this->Menues->save();
        $this->Menues = new Menu();
        $this->alert('success', 'Menú agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function storeCustom(){
        $this->validate();
        $this->Menues->save();
        $this->Menues = new Menu();
        $this->alert('success', 'Menú agregado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }

    public function update(){
        $this->validate();
        $this->Menues->update();
        $this->alert('success', 'Menú modificado con exito');
        $this->emit('render');
        $this->emit('closeModal');
    }
}
