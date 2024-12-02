<?php

namespace App\Http\Livewire\Estadisticaconvenio;

use App\Models\Intranet\Convenio;
use App\Models\Intranet\Tipo;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $userPresent;

    //Tools
    public $perPage = 12;
    public $search;
    protected $queryString = ['search' => ['except' => '']];

    //Theme
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $count = Convenio::where('estado','=','A')->count();

        $Convenios = Convenio::where('estado','=','A');
        $countcm = Convenio::where('estado','=','A')->where('tipoconvenio_id','=',1)->count();
        $countce = Convenio::where('estado','=','A')->where('tipoconvenio_id','=',2)->count();
        $Convenios = $Convenios->paginate($this->perPage);
        return view('livewire.intranet.estadisticaconvenio.index', compact('count', 'Convenios'));

    }

}
