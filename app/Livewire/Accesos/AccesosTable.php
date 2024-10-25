<?php
namespace App\Livewire\Accesos;

use App\Models\Acceso;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Maatwebsite\Excel\Facades\Excel;

class AccesosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshAccesosTable' => '$refresh'];
    protected $model = Acceso::class;

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
        $this->setDataTableFingerprint(route('accesos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Accesos');
    }

    public function query(): Builder
    {
        return Accesos::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Accesos');
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
                fn ($row, Column $column) => view('livewire.accesos.actions-table')->with([
                    'model' => json_encode($row),
                ])
            )->html(),
        ];
    }


}
