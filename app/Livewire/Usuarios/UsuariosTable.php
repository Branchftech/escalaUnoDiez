<?php

namespace App\Livewire\Usuarios;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UsuariosTable extends DataTableComponent
{

    use LivewireAlert;

    protected $listeners = ['refreshUsuariosTable' => '$refresh'];
    protected $model = User::class;

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
        $this->setDataTableFingerprint(route('usuarios') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron usuarios');
    }

    public function query(): Builder
    {
        return User::query();
    }

    public function dataTableFingerprint()
    {
        return md5('usuarios');
    }


    public function builder(): Builder
    {
        return User::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('roles.name', 'like', '%' . $name . '%'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Nombre', 'name')
                ->collapseAlways(),
            Column::make('Nombre', 'name')
                ->sortable()->searchable(),
            Column::make('Email', 'email')
                ->sortable()->searchable(),
            Column::make('Roles', 'name')
                ->format(
                    fn ($value, $row, Column $column) =>
                    // <span class="badge text-bg-warning">Warning</span>
                    // <span class="badge text-bg-light">Light</span>

                    $row->roles->map(function ($rol, $key) {
                        if ($key % 2 == 0) {
                            return '<span class="badge text-bg-light">' . $rol->name . '</span>';
                        } else {
                            return '<span class="badge text-bg-warning">' . $rol->name . '</span>';
                        }
                    })->join(' '),
                )
                ->html()->collapseAlways()->excludeFromColumnSelect(),
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('livewire.roles.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
