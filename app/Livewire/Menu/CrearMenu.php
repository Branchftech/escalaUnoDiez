<?php

namespace App\Livewire\Menu;

use App\Livewire\ServicesComponent;
use App\Models\Menu;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class CrearMenu extends ServicesComponent
{
    public $nombre, $url, $icono, $idRol;
    public $roles;
    public $showModal = false;

    protected $listeners = ['refreshCrearMenu' => '$refresh'];

    public function mount()
    {
        // Cargar los roles disponibles
        $this->roles = Roles::all();
    }

    public function render()
    {
        // Recargar roles en caso de cambios
        $this->roles = Roles::all();

        return view('livewire.menu.crear-menu');
    }

    public function crearMenu()
    {
        // Validar los campos
        $this->validate([
            'nombre' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icono' => 'nullable|string|max:255',
            'idRol' => 'required|exists:roles,id',
        ]);

        try {
            Menu::create([
                'nombre' => $this->nombre,
                'url' => $this->url,
                'icono' => $this->icono,
                'idRol' => $this->idRol,
                'created_by' => Auth::id(),
            ]);

            // Emitir evento para refrescar la tabla de menús
            $this->dispatch('refreshMenuTable')->to(MenuTable::class);

            // Limpiar los campos
            $this->limpiar();

            // Mostrar mensaje de éxito
            if (isset($this->alertService)) {
                $this->alertService->success($this, 'Menú creado con éxito');
            }

        } catch (\Exception $e) {
            // Manejar errores
            if (isset($this->alertService)) {
                $this->alertService->error($this, 'Error al crear el menú');
            }

            if (isset($this->loggerService)) {
                $this->loggerService->logError($e->getMessage() . '\nTraza:\n' . $e->getTraceAsString());
            }
        }
    }

    public function limpiar()
    {
        // Restablecer los campos del formulario
        $this->reset('nombre', 'url', 'icono', 'idRol');
        $this->dispatch('clearSelect2'); // Opcional: limpia select2 si es necesario
        $this->closeModal();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
