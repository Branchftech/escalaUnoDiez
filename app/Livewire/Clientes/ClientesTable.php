<?php

namespace App\Livewire\Clientes;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ClientesTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshClientesTable' => '$refresh'];
    protected $model = Cliente::class;

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
        $this->setDataTableFingerprint(route('clientes') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron clientes');
    }

    public function query(): Builder
    {
        return Cliente::query();
    }

    public function dataTableFingerprint()
    {
        return md5('clientes');
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
            Column::make('Apellido', 'apellido')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Cedula', 'cedula')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Telefono', 'telefono')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Email', 'email')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            // Column::make('Creado por', 'createdBy.name'),
            // Column::make('Fecha Creación', 'created_at'),
            // Column::make('Actualizado por', 'updatedBy.name'),
            // Column::make('Fecha Actualización', 'updated_at'),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.clientes.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
