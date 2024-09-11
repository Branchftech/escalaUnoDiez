<?php

namespace App\Livewire\Insumos;

use App\Models\Insumo;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class InsumosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshInsumosTable' => '$refresh'];
    protected $model = Insumo::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('costo', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('insumos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Insumos');
    }

    public function query(): Builder
    {
        return Insumo::query();
    }

    public function dataTableFingerprint()
    {
        return md5('insumos');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Costo', 'costo')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Cantidad', 'cantidad')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Fecha', 'fecha')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Obra', 'obra.detalle.nombreObra')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            // Nueva columna para mostrar los materiales asociados
            Column::make('Materiales')
            ->label(
                fn ($row, Column $column) => $row->materiales->pluck('nombre')->implode(', ')
            )
            ->html(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.insumos.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Export',
        ];
    }

    public function export()
    {
        // Obtén los IDs seleccionados
        $selectedIds = $this->getSelected();

        // Si no hay bancos seleccionados, evita realizar la exportación
        if (empty($selectedIds)) {
            $this->alert('warning', 'No se han seleccionado insumos para exportar.');
            return;
        }

        // Limpia la selección actual
        $this->clearSelected();

        // Obtén los registros completos de los bancos seleccionados y formatear los datos
        $insumos = Insumo::whereIn('id', $selectedIds)->get()->map(function($insumo) {
            return [
                'ID' => $insumo->id,
                'Costo' => $insumo->costo,
                'Cantidad' => $insumo->cantidad,
                'Fecha' => $insumo->fecha,
                'Obra' => $insumo->obra->detalle->nombreObra,
                'Creado por' => $insumo->createdBy->name ?? 'N/A',
                'Fecha Creación' => $insumo->created_at->format('Y-m-d H:i:s'),
                'Actualizado por' => $insumo->updatedBy->name ?? 'N/A',
                'Fecha Actualización' => $insumo->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        // Exporta los datos a un archivo Excel con encabezados
        return Excel::download(new class($insumos) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $insumos;

            public function __construct($insumos)
            {
                $this->insumos = $insumos;
            }

            public function collection()
            {
                return $this->insumos;
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Costo',
                    'Cantidad',
                    'Fecha',
                    'Obra',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'insumos.xlsx');
    }
}
