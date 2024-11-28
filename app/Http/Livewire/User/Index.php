<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    //Tools
    public $perPage = 10;
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
        $count = User::where('status','=','A')->count();
        $users = User::where('status','=','A')->orderBy('id', 'desc');

        if($this->search){
            $users = $users->where('name', 'LIKE', "%{$this->search}%");
        }

        $users = $users->paginate($this->perPage);

        return view('livewire.user.index', compact('count', 'users'));
    }

    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->status='I';
            if($user->image && Storage::exists($user->image->url)){
                Storage::delete($user->image->url);
            }
            $user->update();
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
