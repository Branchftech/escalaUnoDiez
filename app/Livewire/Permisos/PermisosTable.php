<?php

namespace App\Livewire\Permisos;

use App\Models\Permisos;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ViewComponentColumn;

class PermisosTable extends DataTableComponent
{

    use LivewireAlert;

    protected $listeners = ['refreshPermisosTable' => '$refresh'];
    protected $model = Permisos::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('name', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('permisos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron permisos');
    }

    public function query(): Builder
    {
        return Permisos::query();
    }

    public function dataTableFingerprint()
    {
        return md5('permisos');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Nombre', 'name')
                ->collapseAlways()->excludeFromColumnSelect(),
            Column::make('Nombre', 'name')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('livewire.permisos.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
