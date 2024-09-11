<?php

namespace App\Livewire\FormasPago;

use App\Models\FormaPago;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class FormasPagoTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshFormasPagoTable' => '$refresh'];
    protected $model = FormaPago::class;

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
        $this->setDataTableFingerprint(route('formasPago') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron FormaPagos');
    }

    public function query(): Builder
    {
        return FormaPago::query();
    }

    public function dataTableFingerprint()
    {
        return md5('FormaPagos');
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
                    fn ($row, Column $column) => view('livewire.formas-pago.actions-table')->with([
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
            $this->alert('warning', 'No se han seleccionado formas de pago para exportar.');
            return;
        }

        // Limpia la selección actual
        $this->clearSelected();

        // Obtén los registros completos de los bancos seleccionados y formatear los datos
        $formaPagos = FormaPago::whereIn('id', $selectedIds)->get()->map(function($formaPago) {
            return [
                'ID' => $formaPago->id,
                'Nombre' => $formaPago->nombre,
                'Creado por' => $formaPago->createdBy->name ?? 'N/A',
                'Fecha Creación' => $formaPago->created_at->format('Y-m-d H:i:s'),
                'Actualizado por' => $formaPago->updatedBy->name ?? 'N/A',
                'Fecha Actualización' => $formaPago->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        // Exporta los datos a un archivo Excel con encabezados
        return Excel::download(new class($formaPagos) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $formaPagos;

            public function __construct($formaPagos)
            {
                $this->formaPagos = $formaPagos;
            }

            public function collection()
            {
                return $this->formaPagos;
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
        }, 'formaPagos.xlsx');
    }
}
