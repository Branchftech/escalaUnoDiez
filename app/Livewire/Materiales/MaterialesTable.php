<?php
namespace App\Livewire\Materiales;

use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MaterialesTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshMaterialesTable' => '$refresh'];
    protected $model = Material::class;

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
        $this->setDataTableFingerprint(route('materiales') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron materiales');
    }

    public function query(): Builder
    {
        return Material::query();
    }

    public function dataTableFingerprint()
    {
        return md5('materiales');
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
            Column::make('Precio', 'precioNormal')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Creado por', 'createdBy.name'),
            Column::make('Fecha Creación', 'created_at'),
            Column::make('Actualizado por', 'updatedBy.name'),
            Column::make('Fecha Actualización', 'updated_at'),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.materiales.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
