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
                ->sortable()->searchable(),
            Column::make('Email', 'email')
                ->sortable()->searchable(),
            // Nueva columna para mostrar los roles asociados
            Column::make('Roles')
            ->label(
                fn ($row, Column $column) => $row->roles->pluck('nombre')->implode(', ')
            )
            ->html(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.usuarios.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
