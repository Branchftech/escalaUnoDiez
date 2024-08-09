<?php
namespace App\Livewire\Bancos;

use App\Models\Banco;
use App\Services\AlertService;
use App\Services\LoggerService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BancosTable extends Component
{
    use LivewireAlert;

    public $bancos;

    protected $listeners = ['refreshTable' => 'refreshBancos'];

    protected AlertService $alertService;
    protected LoggerService $loggerService;

    public function __construct()
    {
        $this->alertService = app(AlertService::class);
        $this->loggerService = app(LoggerService::class);
    }

    public function mount()
    {
        $this->refreshBancos();
    }

    public function render()
    {
        return view('livewire.bancos.bancos-table');
    }

    public function refreshBancos()
    {
        $this->bancos = Banco::all();
    }
}
