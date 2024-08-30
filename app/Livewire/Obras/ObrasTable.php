<?php

namespace App\Livewire\Obras;

use App\Models\Obra;
use App\Models\DetalleObra;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ObrasTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshObrasTable' => '$refresh'];
    protected $model = Obra::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(true);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('obras') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron obras');
    }

    public function query(): Builder
    {
        return Obra::query();
    }

    public function dataTableFingerprint()
    {
        return md5('obras');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()->searchable(),

            Column::make('Nombre', 'detalle.nombreObra')
                ->sortable()->searchable(),

            Column::make('Cliente', 'cliente.nombre')
                ->sortable()->searchable(),

            Column::make('Estado', 'estado.nombre')
                ->sortable()->searchable(),
            // Nueva columna para mostrar los materiales asociados
            Column::make('Proveedores')
            ->label(
                fn ($row, Column $column) => $row->proveedores->pluck('nombre')->implode(', ')
            )
            ->html(),
            Column::make('Acciones')
                ->label(
                    fn ($row, Column $column) => view('livewire.obras.actions-table')->with([
                        'model' => ($row),
                    ])
                )->html(),
        ];
    }

}
