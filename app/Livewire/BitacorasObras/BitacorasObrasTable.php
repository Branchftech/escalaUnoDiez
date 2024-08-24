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

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('descripcion', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('bitacorasObras') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron bitacoras de la obra');
    }

    public function query(): Builder
    {
        return BitacoraObra::query();
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
        Column::make('Creado por', 'createdBy.name'),
        Column::make('Fecha Creación', 'created_at'),
        Column::make('Actualizado por', 'updatedBy.name'),
        Column::make('Fecha Actualización', 'updated_at'),
        Column::make('Action')
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

        return Excel::download(new BitacoraObra($bitacoras), 'bitacoras.xlsx');
    }
}
