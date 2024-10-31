<?php
namespace App\Livewire\Servicios;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class ServiciosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshServiciosTable' => '$refresh'];
    protected $model = Servicio::class;

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
        $this->setDataTableFingerprint(route('servicios') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Servicios');
    }

    public function query(): Builder
    {
        return Servicio::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Servicios');
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
            Column::make('Creado por', 'createdBy.name'),
            Column::make('Fecha Creación', 'created_at'),
            Column::make('Actualizado por', 'updatedBy.name'),
            Column::make('Fecha Actualización', 'updated_at'),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.servicios.actions-table')->with([
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
        $servicios = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($servicios) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $servicios;

            public function __construct($servicios)
            {
                $this->servicios = Servicio::whereIn('id', $servicios)->get();
            }

            public function collection()
            {
                return $this->servicios->map(function ($servicio) {
                    return [
                        'ID' => $servicio->id,
                        'Nombre' => $servicio->nombre,
                        'Creado por' => $servicio->createdBy->name ?? 'N/A',
                        'Fecha Creación' => $servicio->created_at,
                        'Actualizado por' => $servicio->updatedBy->name ?? 'N/A',
                        'Fecha Actualización' => $servicio->updated_at,
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
        }, 'servicios.xlsx');
    }
}
