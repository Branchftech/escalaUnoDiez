<?php

namespace App\Livewire\Menu;

use App\Livewire\ServicesComponent;
use App\Models\Menu;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class EditarMenu extends ServicesComponent
{
    public $showModal = false;
    public $model;
    public $menuId, $nombre, $url, $icono, $idRol;
    public $roles;

    protected $listeners = ['cargarModalEditarMenu', 'actualizarMenu' => 'actualizarMenu'];

    public function mount(Menu $model)
    {
        // Inicializar el modelo y cargar datos en los campos
        $this->model = $model;
        $this->menuId = $model->id;
        $this->nombre = $model->nombre;
        $this->url = $model->url;
        $this->icono = $model->icono;
        $this->idRol = $model->idRol;

        // Cargar roles para el selector
        $this->roles = Roles::all();
    }

    public function render()
    {
        // Recargar roles en caso de cambios
        $this->roles = Roles::all();

        return view('livewire.menu.editar-menu');
    }

    public function actualizarMenu()
    {
        // Validar campos antes de actualizar
        $this->validate([
            'nombre' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icono' => 'nullable|string|max:255',
            'idRol' => 'required|exists:roles,id',
        ]);

        try {
            // Actualizar el registro del menú
            $this->model->update([
                'nombre' => $this->nombre,
                'url' => $this->url,
                'icono' => $this->icono,
                'idRol' => $this->idRol,
                'updated_by' => Auth::id(),
            ]);

            // Emitir evento para refrescar la tabla de menús
            $this->dispatch('refreshMenuTable')->to(MenuTable::class);

            // Limpiar y cerrar el modal
            $this->limpiar();
            $this->alertService->success($this, 'Menú actualizado con éxito');
        } catch (\Exception $e) {
            // Manejar errores
            $this->alertService->error($this, 'Error al actualizar el menú');
            $this->loggerService->logError($e->getMessage() . '\nTraza:\n' . $e->getTraceAsString());
        }
    }

    public function cargarModalEditarMenu($model)
    {
        // Cargar el menú seleccionado en el modal
        $this->model = Menu::findOrFail($model['id']);
        $this->menuId = $this->model->id;
        $this->nombre = $this->model->nombre;
        $this->url = $this->model->url;
        $this->icono = $this->model->icono;
        $this->idRol = $this->model->idRol;

        // Cargar roles para el selector
        $this->roles = Roles::all();

        // Establecer showModal como true para abrir el modal
        $this->showModal = true;
    }

    public function limpiar()
    {
        // Resetear los campos del formulario
        $this->reset('nombre', 'url', 'icono', 'idRol');
        $this->dispatch('resetSelect2');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
