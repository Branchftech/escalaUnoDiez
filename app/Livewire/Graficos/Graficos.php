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
            $mesesEnEspanol = [
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre'
            ];
            return $mesesEnEspanol[$mes]; // Convertir el número del mes al nombre en español
        })->toArray();

        $this->egresos = $egresosPorMes->pluck('cantidad_egresos')->toArray();
    }

    public function render()
    {
        return view('livewire.graficos.graficos');
    }
}
