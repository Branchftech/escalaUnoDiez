<?php
namespace App\Livewire\Servicios;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiciosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshServiciosTable' => '$refresh'];
    protected $model = Servicio::class;

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
        $this->setDataTableFingerprint(route('servicios') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Servicios');
    }

    public function query(): Builder
    {
        return Servicio::query();
    }

    public function dataTableFingerprint()
    {
        return md5('Servicios');
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
            Column::make('Action')
                ->label(
                    fn ($row, Column $column) => view('livewire.servicios.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
