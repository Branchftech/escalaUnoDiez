<?php
namespace App\Livewire\Bancos;

use App\Models\Banco;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Maatwebsite\Excel\Facades\Excel;

class BancosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshBancosTable' => '$refresh'];
    protected $model = Banco::class;

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
        $this->setDataTableFingerprint(route('bancos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron bancos');
    }

    public function query(): Builder
    {
        return Banco::query();
    }

    public function dataTableFingerprint()
    {
        return md5('bancos');
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
        BooleanColumn::make('Estado', 'activo'),
        Column::make('Creado por', 'createdBy.name'),
        Column::make('Fecha Creación', 'created_at'),
        Column::make('Actualizado por', 'updatedBy.name'),
        Column::make('Fecha Actualización', 'updated_at'),
        Column::make('Acciones')
            ->label(
                fn ($row, Column $column) => view('livewire.bancos.actions-table')->with([
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
        $bancos = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new Banco($bancos), 'bancos.xlsx');
    }
}
