<?php
namespace App\Livewire\BitacorasObras;

use App\Models\BitacoraObra;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class BitacorasObrasTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshBitacorasObrasTable' => '$refresh'];
    protected $model = BitacoraObra::class;
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('descripcion', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(false);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('bitacorasObras') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron bitacoras de la obra');
    }

    public function query(): Builder
    {
        return BitacoraObra::query();
    }
    public function builder(): Builder
    {
        return BitacoraObra::query()->with('obra')->where('idObra', $this->id);
    }


    public function dataTableFingerprint()
    {
        return md5('BitacorasObras');
    }


    public function columns(): array
    {
        return [
        Column::make('ID', 'id')
            ->sortable()->searchable()
            ->setSortingPillDirections('Asc', 'Desc'),
        Column::make('Descripcion', 'descripcion')
            ->sortable()->searchable()
            ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Obra', 'idObra'),
        Column::make('Creado por', 'createdBy.name'),
        Column::make('Fecha Creación', 'created_at'),
        Column::make('Actualizado por', 'updatedBy.name'),
        Column::make('Fecha Actualización', 'updated_at'),
        Column::make('Acciones')
            ->label(
                fn ($row, Column $column) => view('livewire.bitacoras-obras.actions-table')->with([
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
        $bitacoras = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new class($bitacoras) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $bitacoras;

            public function __construct($bitacoras)
            {
                $this->bitacoras = BitacoraObra::whereIn('id', $bitacoras)->get();
            }

            public function collection()
            {
                return $this->bitacoras->map(function ($bitacora) {
                    return [
                        'ID' => $bitacora->id,
                        'Descripción' => $bitacora->descripcion,
                        'ID Obra' => $bitacora->idObra,
                        'Creado por' => $bitacora->created_by,
                        'Fecha Creación' => $bitacora->created_at,
                        'Actualizado por' => $bitacora->updated_by,
                        'Fecha Actualización' => $bitacora->updated_at,
                    ];
                });
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Descripción',
                    'ID Obra',
                    'Creado por',
                    'Fecha Creación',
                    'Actualizado por',
                    'Fecha Actualización',
                ];
            }
        }, 'bitacoras.xlsx');

    }
}
