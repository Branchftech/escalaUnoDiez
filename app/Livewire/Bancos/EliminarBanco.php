<?php
namespace App\Livewire\Bancos;

use App\Livewire\ServicesComponent;
use App\Models\Banco;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class EliminarBanco extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminar'];

    public function mount(Banco $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.Bancos.eliminar-Banco');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarBanco()
    {

        try {
            $user = Auth::user();
            Banco::eliminarBanco($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshBancosTable')->to(BancosTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Banco eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Banco');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminar($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

}
