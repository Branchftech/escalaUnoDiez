<?php

namespace App\Livewire\Obras;

use App\Models\Obra;
use App\Models\DetalleObra;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;

class ObrasTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshObrasTable' => '$refresh'];
    protected $model = Obra::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('obras') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron obras');
    }

    public function query(): Builder
    {
        return Obra::query();
    }

    public function dataTableFingerprint()
    {
        return md5('obras');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable(),

            Column::make('Nombre', 'detalle.nombreObra')
                ->sortable()->searchable(),

            Column::make('Cliente', 'cliente.nombre')
                ->sortable()->searchable(),

            Column::make('Estado', 'estado.nombre')
                ->sortable()->searchable(),
            // Nueva columna para mostrar los materiales asociados
            Column::make('Proveedores')
            ->label(
                fn ($row, Column $column) => $row->proveedores->pluck('nombre')->implode(', ')
            )
            ->html(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.obras.actions-table')->with([
                        'model' => ($row),
                    ])
                )->html(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Exportar',
        ];
    }

    public function export()
    {
        $obras = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($obras) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $obras;

            public function __construct($obras)
            {
                $this->obras = Obra::whereIn('id', $obras)->get();
            }

            public function collection()
            {
                return $this->obras->map(function ($obra) {
                    return [
                        'ID' => $obra->id,
                        'Presupuesto' => $obra->detalle->total,
                        'Estado' => $obra->estado->nombre,
                        'Fecha Inicio' => $obra->detalle->fechaInicio,
                        'Fecha Fin' => $obra->detalle->fechaFin,
                        'Cliente' => $obra->cliente->nombre,
                        'Proveedores' => $obra->proveedores->pluck('nombre')->implode(', '),
                        'Creado por' => $obra->createdBy->name ?? 'N/A',
                        'Fecha Creación' => $obra->created_at,
                        'Actualizado por' => $obra->updatedBy->name ?? 'N/A',
                        'Fecha Actualización' => $obra->updated_at,
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Presupuesto',
                    'Estado',
                    'Fecha Inicio',
                    'Fecha Fin',
                    'Cliente',
                    'Proveedores',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'obras.xlsx');
    }
}
