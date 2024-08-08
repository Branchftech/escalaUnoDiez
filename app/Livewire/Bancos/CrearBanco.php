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

    public Banco $banco;
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

        try {
            $banco = Banco::create(['nombre' => $this->nombre]);

            $this->limpiar();
            $this->emitTo(BancosTable::class, 'refreshBancosTable');
            $this->alertService->success($this, 'Banco creado con éxito');

        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el banco');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset(['nombre','showModal']);
    }

}
