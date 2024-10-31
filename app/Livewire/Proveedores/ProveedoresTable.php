<?php
namespace App\Livewire\Proveedores;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Maatwebsite\Excel\Facades\Excel;

class ProveedoresTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshProveedoresTable' => '$refresh'];
    protected $model = Proveedor::class;

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
        $this->setDataTableFingerprint(route('proveedores') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Proveedores');
        // Establecer valores aceptados para la paginación
        $this->setPerPageAccepted([5, 10, 25, 50]); // Incluye 5 en la lista
        // Establecer el número de resultados por página a 5
        $this->setPerPage(5); // Aquí estableces el límite de resultados
    }

    public function query(): Builder
    {
        return Proveedor::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Proveedores');
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
            // Column::make('Direccion', 'direccion')
            //     ->sortable()->searchable()
            //     ->setSortingPillDirections('Asc', 'Desc'),
            // Column::make('Telefono', 'telefono')
            //     ->sortable()->searchable()
            //     ->setSortingPillDirections('Asc', 'Desc'),
            // Column::make('Email', 'email')
            //     ->sortable()->searchable()
            //     ->setSortingPillDirections('Asc', 'Desc'),
            //Column::make('Servicio', 'Servicios.nombre'),
            // Column::make('Fecha Creación', 'created_at'),
            // Column::make('Actualizado por', 'updatedBy.name'),
            // Column::make('Fecha Actualización', 'updated_at'),
            // Nueva columna para mostrar los materiales asociados
            Column::make('Servicios')
            ->label(
                fn ($row, Column $column) => $row->servicios->pluck('nombre')->implode(', ')
            )
            ->html(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.proveedores.actions-table')->with([
                        'model' => json_encode($row),
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
        $proveedores = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($proveedores) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $proveedores;

            public function __construct($proveedores)
            {
                $this->proveedores = Proveedor::whereIn('id', $proveedores)->get();
            }

            public function collection()
            {
                return $this->proveedores->map(function ($proveedor) {
                    return [
                        'ID' => $proveedor->id,
                        'Nombre' => $proveedor->nombre,
                        'Servicios' => $proveedor->servicios->pluck('nombre')->implode(', '),
                        'Creado por' => $proveedor->createdBy->name ?? 'N/A',
                        'Fecha Creación' => $proveedor->created_at,
                        'Actualizado por' => $proveedor->updatedBy->name ?? 'N/A',
                        'Fecha Actualización' => $proveedor->updated_at,
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Nombre',
                    'Servicios',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'proveedores.xlsx');
    }
}
