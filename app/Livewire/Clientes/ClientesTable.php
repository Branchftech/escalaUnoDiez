<?php

namespace App\Livewire\Clientes;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class ClientesTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshClientesTable' => '$refresh'];
    protected $model = Cliente::class;

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
        $this->setDataTableFingerprint(route('clientes') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron clientes');
    }

    public function query(): Builder
    {
        return Cliente::query();
    }

    public function dataTableFingerprint()
    {
        return md5('clientes');
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
            Column::make('Apellido', 'apellido')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Cedula', 'cedula')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Telefono', 'telefono')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Email', 'email')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            // Column::make('Creado por', 'createdBy.name'),
            // Column::make('Fecha Creación', 'created_at'),
            // Column::make('Actualizado por', 'updatedBy.name'),
            // Column::make('Fecha Actualización', 'updated_at'),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.clientes.actions-table')->with([
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
            $this->alert('warning', 'No se han seleccionado clientes para exportar.');
            return;
        }

        // Limpia la selección actual
        $this->clearSelected();

        // Obtén los registros completos de los bancos seleccionados y formatear los datos
        $clientes = Cliente::whereIn('id', $selectedIds)->get()->map(function($cliente) {
            return [
                'ID' => $cliente->id,
                'Nombre' => $cliente->nombre,
                'Apellido' => $cliente->apellido,
                'Cedula' => $cliente->cedula,
                'Telefono' => $cliente->telefono,
                'Email' => $cliente->email,
                'Creado por' => $cliente->createdBy->name ?? 'N/A',
                'Fecha Creación' => $cliente->created_at->format('Y-m-d H:i:s'),
                'Actualizado por' => $cliente->updatedBy->name ?? 'N/A',
                'Fecha Actualización' => $cliente->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        // Exporta los datos a un archivo Excel con encabezados
        return Excel::download(new class($clientes) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $clientes;

            public function __construct($clientes)
            {
                $this->clientes = $clientes;
            }

            public function collection()
            {
                return $this->clientes;
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Nombre',
                    'Apellido',
                    'Cedula',
                    'Telefono',
                    'Email',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'clientes.xlsx');
    }
}
