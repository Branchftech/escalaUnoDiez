<?php
namespace App\Livewire\Bancos;

use App\Models\Banco;
use App\Services\AlertService;
use App\Services\LoggerService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditarBanco extends Component
{
    use LivewireAlert;

    public $bancoId, $nombre;
    public $showModal = false;
    protected AlertService $alertService;
    protected LoggerService $loggerService;

    public function __construct()
    {
        $this->alertService = app(AlertService::class);
        $this->loggerService = app(LoggerService::class);
    }

    public function mount(Banco $banco)
    {
        $this->bancoId = $banco->id;
        $this->nombre = $banco->nombre;
    }

    public function render()
    {
        return view('livewire.bancos.editar-banco');
    }

    public function editarBanco()
    {
        dd($this->bancoId);

        $banco = Banco::findOrFail($bancoId);
        $this->bancoId = $banco->id;
        $this->nombre = $banco->nombre;

        $banco = Banco::find($this->bancoId);
        $banco->update(['nombre' => $this->nombre]);

        $this->dispatch('refreshTable');
        $this->alertService->success($this, 'Banco actualizado con éxito');
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function limpiar()
    {
        $this->reset('nombre');
    }
}
