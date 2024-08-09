<?php

namespace App\Livewire\Bancos;

use App\Models\Banco;
use App\Services\AlertService;
use App\Services\LoggerService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CrearBanco extends Component
{
    use LivewireAlert;

    public $nombre;
    public $showModal = false;
    protected AlertService $alertService;
    protected LoggerService $loggerService;

    public function __construct()
    {
        $this->alertService = app(AlertService::class);
        $this->loggerService = app(LoggerService::class);
    }

    public function render()
    {
        return view('livewire.bancos.crear-banco');
    }

    public function crearBanco()
    {
        $this->validate([
            'nombre' => 'required|string|unique:banco,nombre',
        ]);

        Banco::create(['nombre' => $this->nombre, 'activo'=>1]);

        $this->dispatch('refreshTable');
        $this->limpiar();
        $this->alertService->success($this, 'Banco creado con éxito');
    }

    public function limpiar()
    {
        $this->reset('nombre');
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
