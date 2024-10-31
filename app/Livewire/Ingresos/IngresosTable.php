<?php

namespace App\Livewire\Ingresos;

use App\Models\Ingreso;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class IngresosTable extends DataTableComponent
{
    use LivewireAlert;

    protected $listeners = ['refreshIngresosTable' => '$refresh'];
    protected $model = Ingreso::class;
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
        $this->setDataTableFingerprint(route('ingresos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Ingresos');
    }

    public function query(): Builder
    {
        return Ingreso::query();
    }

    public function builder(): Builder
    {
        return Ingreso::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Ingreso');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Factura', 'factura')
                ->sortable()->searchable(),
            Column::make('Cantidad', 'cantidad')
                ->sortable()->searchable()
                ->format(function ($value) {
                    return '$' . number_format($value, 2); // Formatea el número con dos decimales
                }),
            Column::make('Fecha', 'fecha')
                ->sortable()->searchable(),
            Column::make('Concepto', 'concepto')
                ->sortable()->searchable(),
            Column::make('Obra', 'obra.detalle.nombreObra')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Cliente', 'cliente.nombre')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
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
                    fn ($row, Column $column) => view('livewire.ingresos.actions-table')->with([
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
        $ingresos = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($ingresos) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $ingresos;

            public function __construct($ingresos)
            {
                $this->ingresos = Ingreso::whereIn('id', $ingresos)->get();
            }

            public function collection()
            {
                return $this->ingresos->map(function ($ingreso) {
                    return [
                        'ID' => $ingreso->id,
                        'Factura' => $ingreso->factura,
                        'Cantidad' => $ingreso->cantidad,
                        'Fecha' => $ingreso->fecha,
                        'Concepto' => $ingreso->concepto,
                        'Creado por' => $ingreso->createdBy->name ?? 'N/A',
                        'Fecha Creación' => $ingreso->created_at,
                        'Actualizado por' => $ingreso->updatedBy->name ?? 'N/A',
                        'Fecha Actualización' => $ingreso->updated_at,
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Factura',
                    'Cantidad',
                    'Fecha',
                    'Concepto',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'ingresos.xlsx');
    }
}
