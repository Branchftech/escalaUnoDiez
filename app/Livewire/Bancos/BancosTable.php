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

    public function render()
    {
        $this->bancos = Banco::all();
        return view('livewire.bancos.bancos-table');
    }
}
