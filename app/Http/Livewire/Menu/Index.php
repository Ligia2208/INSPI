<?php

namespace App\Http\Livewire\Menu;

use App\Models\CoreBase\Menu;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    //Listeners
    protected $listeners = ['render'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Menu::count();
        $Menues = Menu::orderBy('orden', 'asc');

        if($this->search){
            $Menues = $Menues->where('nombre', 'LIKE', "%{$this->search}%");
        }

        $Menues = $Menues->paginate($this->perPage);

        return view('livewire.corebase.menu.index', compact('count', 'Menues'));
    }

    public function destroy(Menu $Menues)
    {
        try{
            $Menues->delete();
            $this->alert('success', 'Eliminación con exito');
        }catch(Exception $e){
            $this->alert('error',
                'Ocurrio un error en la eliminación: '.$e->getMessage(),
                [
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Entiendo',
                    'timer' => null,
                ]);
        }
    }
}
