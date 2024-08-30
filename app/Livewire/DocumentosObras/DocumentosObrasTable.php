<?php
namespace App\Livewire\DocumentosObras;

use App\Models\DocumentoObra;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Maatwebsite\Excel\Facades\Excel;

class DocumentosObrasTable extends DataTableComponent{
    use LivewireAlert;

    protected $listeners = ['refreshDocumentosObrasTable' => '$refresh'];
    protected $model = DocumentoObra::class;
    public $obraId;

    public function mount($id)
    {
        $this->obraId = $id;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('nombre', 'asc');
        $this->setSingleSortingDisabled();
        $this->setColumnSelectStatus(true);
        $this->setQueryStringStatus(true);
        $this->setOfflineIndicatorStatus(true);
        $this->setEagerLoadAllRelationsStatus(false);
        $this->setRememberColumnSelectionEnabled();
        $this->setDataTableFingerprint(route('documentosObras') . '-' . $this->dataTableFingerprint());
        $this->setEmptyMessage('No se encontraron documentos de la obra');
    }

    public function query(): Builder
    {
        return DocumentoObra::query();
    }
    public function builder(): Builder
    {
        return DocumentoObra::query()->with('obra')->where('idObra', $this->obraId);
    }

    public function dataTableFingerprint()
    {
        return md5('documentosObras');
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
        Column::make('Tipo Documento', 'tipoDocumento.nombre'),
        Column::make('Creado por', 'createdBy.name'),
        Column::make('Fecha Creación', 'created_at'),
        Column::make('Actualizado por', 'updatedBy.name'),
        Column::make('Fecha Actualización', 'updated_at'),
        Column::make('Acciones')
            ->label(
                fn ($row, Column $column) => view('livewire.documentos-obras.actions-table')->with([
                    'model' => json_encode($row),
                ])
            )->html(),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Export',
        ];
    }

    public function export()
    {
        $documentos = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new DocumentoObra($documentos), 'documentos.xlsx');
    }
}
