<?php

namespace App\Livewire\Graficos;

use Livewire\Component;
use App\Models\Egreso;

class Graficos extends Component
{
    // public $labels = [];
    // public $egresos = [];
    // public $ingresos = [];

    // public function mount()
    // {
    //     // Datos predefinidos
    //     $this->labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo']; // Meses
    //     $this->egresos = [1000, 2000, 1500, 1700, 1800]; // Egresos por mes
    //     $this->ingresos = [1500, 2500, 3000, 2000, 3500]; // Ingresos por mes
    // }
    public $labels = [];
    public $egresos = [];

    public function mount()
    {
        $egresosPorMes = Egreso::getEgresosGrafica();

        $this->labels = $egresosPorMes->pluck('mes')->map(function($mes) {
            return date('F', mktime(0, 0, 0, $mes, 10)); // Convertir el número del mes al nombre (Enero, Febrero, etc.)
        })->toArray();

        $this->egresos = $egresosPorMes->pluck('cantidad_egresos')->toArray();
    }

    public function render()
    {
        return view('livewire.graficos.graficos');
    }
}
