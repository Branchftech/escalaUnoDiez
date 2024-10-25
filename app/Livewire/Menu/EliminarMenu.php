<?php

namespace App\Livewire\Menu;

use App\Livewire\ServicesComponent;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class EliminarMenu extends ServicesComponent
{
    public $model;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarMenu'];

    public function mount(Menu $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.menu.eliminar-menu');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarMenu()
    {
        try {
            $user = Auth::user();
            Menu::eliminarIngreso($this->model->id, $user->id);
            $this->reset('showModal');
            $this->dispatch('refreshMenuTable')->to(MenuTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Menu eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Menu');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarMenu($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
