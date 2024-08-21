<?php

namespace App\Livewire\Insumos;

use App\Models\Insumo;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InsumosTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshInsumosTable' => '$refresh'];
    protected $model = Insumo::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('costo', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('insumos') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron Insumos');
    }

    public function query(): Builder
    {
        return Insumo::query();
    }

    public function dataTableFingerprint()
    {
        return md5('insumos');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Costo', 'costo')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Cantidad', 'cantidad')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Fecha', 'fecha')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            Column::make('Obra', 'obra.detalle.nombreObra')
                ->sortable()->searchable()
                ->setSortingPillDirections('Asc', 'Desc'),
            // Nueva columna para mostrar los materiales asociados
            Column::make('Materiales')
            ->label(
                fn ($row, Column $column) => $row->materiales->pluck('nombre')->implode(', ')
            )
            ->html(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.insumos.actions-table')->with([
                        'model' => json_encode($row),
                    ])
                )->html(),
        ];
    }
}
