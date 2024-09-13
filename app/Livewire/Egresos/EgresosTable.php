<?php
namespace App\Livewire\Egresos;

use App\Models\Egreso;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class EgresosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshEgresosTable' => '$refresh'];
    protected $model =Egreso::class;
    public $id;

    // public function mount($id)
    // {
    //     $this->id = $id;
    // }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        //$this->setDefaultSort('descripcion', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(false);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('egresos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Egresos');
    }

    public function query(): Builder
    {
        return Egreso::query();
    }
    public function builder(): Builder
    {
        return Egreso::query();//->with('obra')->where('idObra', $this->id);
    }


    public function dataTableFingerprint()
    {
        return md5('Egreso');
    }


    public function columns(): array
    {
        return [
        Column::make('ID', 'id')
            ->sortable()->searchable()
            ->setSortingPillDirections('Asc', 'Desc'),
        Column::make('Concepto', 'concepto'),
        Column::make('Cantidad', 'cantidad'),
        Column::make('Fecha', 'fecha'),
        Column::make('Obra', 'obra.detalle.nombreObra')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
        Column::make('Proveedor', 'proveedor.nombre')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
        // Nueva columna para mostrar los servicios asociados
        Column::make('Servicios')
        ->label(
            fn ($row, Column $column) => $row->servicios->pluck('nombre')->implode(', ')
        ),
        Column::make('Forma de Pago', 'formaPago.nombre')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
        Column::make('Banco', 'banco.nombre')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
        Column::make('Creado por', 'createdBy.name')->deselected(),
        Column::make('Fecha Creación', 'created_at')->deselected(),
        Column::make('Actualizado por', 'updatedBy.name')->deselected(),
        Column::make('Fecha Actualización', 'updated_at')->deselected(),
        Column::make('Acciones')
            ->label(
                fn ($row, Column $column) => view('livewire.egresos.actions-table')->with([
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
        $egresos = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($egresos) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $egresos;

            public function __construct($egresos)
            {
                $this->egresos = Egreso::whereIn('id', $egresos)->get();
            }

            public function collection()
            {
                return $this->egresos->map(function ($egreso) {
                    return [
                        'ID' => $egreso->id,
                        'Concepto' => $egreso->concepto,
                        'Cantidad' => $egreso->cantidad,
                        'Fecha' => $egreso->fecha,
                        'Creado por' => $egreso->created_by,
                        'Fecha Creación' => $egreso->created_at,
                        'Actualizado por' => $egreso->updated_by,
                        'Fecha Actualización' => $egreso->updated_at,
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Concepto',
                    'Cantidad',
                    'Fecha',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'egresos.xlsx');

    }
}
