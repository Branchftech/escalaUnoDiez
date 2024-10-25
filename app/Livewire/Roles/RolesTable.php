<?php

namespace App\Livewire\Roles;

use App\Models\Roles;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

class RolesTable  extends DataTableComponent
{

    use LivewireAlert;

    protected $listeners = ['refreshRolesTable' => '$refresh'];
    protected $model = Roles::class;

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
        $this->setDataTableFingerprint(route('roles') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron roles');
    }

    public function query(): Builder
    {
        return Roles::query();
    }

    public function dataTableFingerprint()
    {
        return md5('roles');
    }


    public function builder(): Builder
    {
        return Roles::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('roles.name', 'like', '%' . $name . '%'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),

            Column::make('Nombre', 'name')
                ->sortable()->searchable(),

            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('livewire.roles.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
