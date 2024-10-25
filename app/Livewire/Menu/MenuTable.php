<?php

namespace App\Livewire\Menu;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class MenuTable extends DataTableComponent
{
    use LivewireAlert;

    protected $listeners = ['refreshMenuTable' => '$refresh'];
    protected $model = Menu::class;
    public $id;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(false);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('menu') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Menu');
    }

    public function query(): Builder
    {
        return Menu::query();
    }

    public function builder(): Builder
    {
        return Menu::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Menu');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Nombre', 'nombre')
                ->sortable()->searchable(),
            Column::make('Url', 'url')
                ->sortable()->searchable(),
            Column::make('Rol', 'rol.name')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Creado por', 'createdBy.name')->deselected(),
            Column::make('Fecha Creación', 'created_at')->deselected(),
            Column::make('Actualizado por', 'updatedBy.name')->deselected(),
            Column::make('Fecha Actualización', 'updated_at')->deselected(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.menu.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }

}
