<?php

namespace App\Livewire\Paises;

use App\Models\Pais;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class PaisesTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshPaisesTable' => '$refresh'];
    protected $model = Pais::class;

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
        $this->setEmptyMessage('No se encontraron Pais');
    }

    public function query(): Builder
    {
        return Pais::query();
    }

    public function dataTableFingerprint()
    {
        return md5('paises');
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
                    fn ($row, Column $column) => view('livewire.paises.actions-table')->with([
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
            $this->alert('warning', 'No se han seleccionado paises para exportar.');
            return;
        }

        // Limpia la selección actual
        $this->clearSelected();

        // Obtén los registros completos de los bancos seleccionados y formatear los datos
        $paises = Pais::whereIn('id', $selectedIds)->get()->map(function($pais) {
            return [
                'ID' => $pais->id,
                'Nombre' => $pais->nombre,
                'Creado por' => $pais->createdBy->name ?? 'N/A',
                'Fecha Creación' => $pais->created_at->format('Y-m-d H:i:s'),
                'Actualizado por' => $pais->updatedBy->name ?? 'N/A',
                'Fecha Actualización' => $pais->updated_at->format('Y-m-d H:i:s'),
            ];
        });

        // Exporta los datos a un archivo Excel con encabezados
        return Excel::download(new class($paises) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $paises;

            public function __construct($paises)
            {
                $this->paises = $paises;
            }

            public function collection()
            {
                return $this->paises;
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
        }, 'paises.xlsx');
    }
}
