<?php

namespace App\Livewire\Estados;

use App\Models\Estado;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class EstadosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshEstadosTable' => '$refresh'];
    protected $model = Estado::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('nombre', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('regiones') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Estados');
    }

    public function query(): Builder
    {
        return Estado::query();
    }

    public function dataTableFingerprint()
    {
        return md5('estados');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Nombre', 'nombre')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.estados.actions-table')->with([
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
            $this->alert('warning', 'No se han seleccionado estados para exportar.');
            return;
        }

        // Limpia la selección actual
        $this->clearSelected();

        // Obtén los registros completos de los bancos seleccionados y formatear los datos
        $estados = Estado::whereIn('id', $selectedIds)->get()->map(function($estado) {
            return [
                'ID' => $estado->id,
                'Nombre' => $estado->nombre,
                'Creado por' => $estado->createdBy->name ?? 'N/A',
                'Fecha Creación' => $estado->created_at->format('Y-m-d H:i:s'),
                'Actualizado por' => $estado->updatedBy->name ?? 'N/A',
                'Fecha Actualización' => $estado->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        // Exporta los datos a un archivo Excel con encabezados
        return Excel::download(new class($estados) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $estados;

            public function __construct($estados)
            {
                $this->estados = $estados;
            }

            public function collection()
            {
                return $this->estados;
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Nombre',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'estados.xlsx');
    }
}
