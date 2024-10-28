<?php
// app/Livewire/Accesos/CrearAcceso.php
namespace App\Livewire\Accesos;

use App\Livewire\ServicesComponent;
use App\Models\Acceso;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class CrearAcceso extends ServicesComponent
{
    public $nombre, $url, $icono, $selectedRoles = [];
    public $showModal = false;

    public function render()
    {
        return view('livewire.accesos.crear-acceso', [
            'roles' => Roles::all()
        ]);
    }

    public function crearAcceso()
    {
        $this->validate([
            'nombre' => 'required|string|unique:acceso,nombre,NULL,id,deleted_at,NULL',
            'url' => 'required|string|unique:acceso,url,NULL,id,deleted_at,NULL',
            'icono' => 'nullable|string',
        ]);

        try {
            $user = Auth::user();
            $acceso = Acceso::create([
                'nombre' => $this->nombre,
                'url' => $this->url,
                'icono' => $this->icono,
                'created_by' => $user->id,
            ]);

            // Asigna los roles seleccionados al acceso
            $acceso->roles()->sync($this->selectedRoles);

            $this->dispatch('refreshAccesosTable')->to(AccesosTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Acceso creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el Acceso');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('nombre', 'url', 'icono', 'selectedRoles');
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
