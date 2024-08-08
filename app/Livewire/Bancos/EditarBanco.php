<?php
namespace App\Http\Livewire\Bancos;

use App\Models\Banco;
use App\Services\AlertService;
use App\Services\LoggerService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EditarBanco extends Component
{
    use LivewireAlert;

    public Banco $banco;
    public $nombre;
    public $bancoId;
    public $showModal = false;

    protected $listeners = ['openEditModal' => 'openModal'];

    protected AlertService $alertService;
    protected LoggerService $loggerService;

    public function mount()
    {
        $this->alertService = app(AlertService::class);
        $this->loggerService = app(LoggerService::class);
    }

    public function render()
    {
        return view('livewire.bancos.editar-banco');
    }

    public function openModal($bancoId)
    {
        $this->bancoId = $bancoId;
        $this->banco = Banco::find($bancoId);
        $this->nombre = $this->banco->nombre;
        $this->showModal = true;
    }

    public function actualizarBanco()
    {
        $this->validate([
            'nombre' => 'required|string|unique:banco,nombre,' . $this->banco->id,
        ]);

        try {
            $this->banco->update(['nombre' => $this->nombre]);
            $this->limpiar();
            $this->emitTo('bancos.bancos-table', 'refreshBancosTable');
            $this->alert('Banco actualizado con éxito', 'success');
        } catch (\Exception $e) {
            $this->alert('Error al actualizar el banco', 'error');
        }
    }

    public function limpiar()
    {
        $this->reset(['nombre', 'showModal']);
        $this->showModal = false;
    }
}
