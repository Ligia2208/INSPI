<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\CoreBase\Cargo;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    //Tools
    public $perPage = 20;
    public $searchc;
    public $searcha;
    public $searchd;
    protected $queryString = ['searchc' => ['except' => ''], 'searcha' => ['except' => ''], 'searchd' => ['except' => '']];

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
        return view('livewire.dashboard.index');
    }

}
