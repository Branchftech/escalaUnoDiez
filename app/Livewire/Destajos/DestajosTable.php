<?php

namespace App\Livewire\Destajos;

use App\Models\Destajo;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class DestajosTable extends DataTableComponent
{
    use LivewireAlert;

    protected $listeners = ['refreshDestajosTable' => '$refresh'];
    protected $model = Destajo::class;
    public $id;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(false);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('destajos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Destajos');
    }

    public function query(): Builder
    {
        return Destajo::query();
    }

    public function builder(): Builder
    {
        return Destajo::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Destajo');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Presupuesto', 'presupuesto')
                ->sortable()->searchable(),
            Column::make('Obra', 'obra.detalle.nombreObra')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Proveedor', 'proveedor.nombre')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Servicios')
                ->label(
                    fn ($row, Column $column) => $row->servicios->pluck('nombre')->implode(', ')
                )
                ->html(),
            Column::make('Creado por', 'createdBy.name')->deselected(),
            Column::make('Fecha Creación', 'created_at')->deselected(),
            Column::make('Actualizado por', 'updatedBy.name')->deselected(),
            Column::make('Fecha Actualización', 'updated_at')->deselected(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.destajos.actions-table')->with([
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
        $destajos = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($destajos) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $destajos;

            public function __construct($destajos)
            {
                $this->destajos = Destajo::whereIn('id', $destajos)->get();
            }

            public function collection()
            {
                return $this->destajos->map(function ($destajo) {
                    return [
                        'ID' => $destajo->id,
                        'Presupuesto' => $destajo->presupuesto,
                        'Creado por' => $destajo->created_by,
                        'Fecha Creación' => $destajo->created_at,
                        'Actualizado por' => $destajo->updated_by,
                        'Fecha Actualización' => $destajo->updated_at,
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Presupuesto',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'destajos.xlsx');
    }
}
