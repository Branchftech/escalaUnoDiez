<?php

namespace App\Livewire\Graficos;

use Livewire\Component;
use App\Models\Egreso;

class Graficos extends Component
{
    public $labels = [];
    public $egresos = [];

    public function mount()
    {
        $egresosPorMes = Egreso::getEgresosGrafica();

        // Convertir los meses numéricos a nombres en español
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

        // Recoger la cantidad de egresos
        $this->egresos = $egresosPorMes->pluck('cantidad_egresos')->toArray();
    }

    public function render()
    {
        // Emitir los datos si son válidos
        if (!empty($this->labels) && !empty($this->egresos)) {
            $this->dispatch('chartDataReady', [
                'series' => [
                    [
                        'name' => 'Egresos',
                        'data' => $this->egresos
                    ]
                ],
                'categories' => $this->labels
            ]);
        }

        return view('livewire.graficos.graficos');
    }
}
