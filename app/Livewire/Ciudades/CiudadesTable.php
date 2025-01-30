<?php
namespace App\Livewire\Ciudades;

use App\Models\Ciudad;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Maatwebsite\Excel\Facades\Excel;

class CiudadesTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshCiudadesTable' => '$refresh'];
    protected $model = Ciudad::class;

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
        $this->setEmptyMessage('No se encontraron Ciudades');
        // Establecer valores aceptados para la paginación
        $this->setPerPageAccepted([5, 10, 25, 50]); // Incluye 5 en la lista
        // Establecer el número de resultados por página a 5
        $this->setPerPage(5); // Aquí estableces el límite de resultados
    }

    public function query(): Builder
    {
        return Ciudad::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Ciudades');
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
                    fn ($row, Column $column) => view('livewire.ciudades.actions-table')->with([
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
        $ciudades = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($ciudades) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $ciudades;

            public function __construct($ciudades)
            {
                $this->ciudades = Ciudad::whereIn('id', $ciudades)->get();
            }

            public function collection()
            {
                return $this->ciudades->map(function ($ciudad) {
                    return [
                        'ID' => $ciudad->id,
                        'Nombre' => $ciudad->nombre,
                        'Creado por' => $ciudad->createdBy->name ?? 'N/A',
                        'Fecha Creación' => $ciudad->created_at,
                        'Actualizado por' => $ciudad->updatedBy->name ?? 'N/A',
                        'Fecha Actualización' => $ciudad->updated_at,
                    ];
                });
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
        }, 'ciudades.xlsx');
    }
}
