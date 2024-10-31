<?php
// namespace App\Livewire\Obras;

// use App\Livewire\ServicesComponent;
// use App\Models\Obra;
// use Illuminate\Support\Facades\Auth;

// class EliminarObra extends ServicesComponent
// {
//     public $model;
//     public $showModal = false;
//     public $listeners = ['cargarModalEliminarObra' => 'cargarModalEliminarObra'];

//     public function mount($id)
//     {
//         $this->model = Obra::find($id);
//     }
//     public function render()
//     {
//         return view('livewire.obras.eliminar-obra');
//     }

//     public function cargarModalEliminarObra($id)
//     {
//         dd("hola");
//         // Cargar el modelo `Obra` usando el id recibido
//        // $this->model = Obra::find($id);
//         $this->showModal = true;
//     }

//     public function eliminarObra()
//     {

//         try {
//             $user = Auth::user();
//             Obra::eliminarObra($this->model->id, $user->id);
//             $this->reset( 'showModal');
//             $this->dispatch('refreshObrasTable')->to(ObrasTable::class);
//             $this->render();
//             $this->closeModal();
//             $this->alertService->success($this, 'Obra eliminado con éxito');
//         } catch (\Exception $th) {
//             $this->alertService->error($this, 'No se pudo eliminar el Obra');
//             $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
//         }
//     }

//     public function closeModal()
//     {
//         $this->showModal = false;
//     }
// }

namespace App\Livewire\Obras;

use App\Livewire\ServicesComponent;
use App\Models\Obra;
use Illuminate\Support\Facades\Auth;

class EliminarObra extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarObra' => 'cargarModalEliminarObra'];

    public function render()
    {
        return view('livewire.obras.eliminar-obra');
    }

    public function cargarModalEliminarObra($id)
    {
        // Cargar el modelo usando el id recibido
        $this->model = Obra::find($id);
        $this->showModal = true;
    }

    public function eliminarObra()
    {
        try {
            $user = Auth::user();
            Obra::eliminarObra($this->model->id, $user->id);
            $this->reset('showModal');
            $this->dispatch('refreshObrasTable')->to(ObrasTable::class);
            $this->alertService->success($this, 'Obra eliminada con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar la obra');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
