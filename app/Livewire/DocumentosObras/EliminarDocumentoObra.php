<?php
namespace App\Livewire\DocumentosObras;

use App\Livewire\ServicesComponent;
use App\Models\DocumentoObra;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class EliminarDocumentoObra extends ServicesComponent
{
    public $model;
    use WithFileUploads;
    public $showModal = false;
    public $listeners = ['cargarModalEliminarDocumentoObra','visualizarDocumento'];

    public function mount(DocumentoObra $model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return view('livewire.documentos-obras.eliminar-documento-obra');
    }

    public function cancelModal()
    {
        $this->showModal = false;
    }

    public function eliminarDocumentoObra()
    {

        try {
            $user = Auth::user();
            DocumentoObra::eliminarDocumentoObra($this->model->id, $user->id);
            $this->reset( 'showModal');
            $this->dispatch('refreshDocumentosObrasTable')->to(DocumentosObrasTable::class);
            $this->render();
            $this->closeModal();
            $this->alertService->success($this, 'Documento eliminado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'No se pudo eliminar el Documento');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function cargarModalEliminarDocumentoObra($model)
    {
        $this->model = (object) $model;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function visualizarDocumento($model)
    {
        $documento = DocumentoObra::find($model['id']);

        if ($documento) {
            $path = storage_path('app/' . $documento->path);

            if (file_exists($path)) {
                // Obtener el nombre original del archivo
                $filename = basename($documento->path);

                // Intentar mostrar el archivo en el navegador, si es posible
                return response()->file($path, [
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                ]);
            } else {
                return redirect()->back()->with('error', 'El archivo no existe o ha sido eliminado.');
            }
        } else {
            return redirect()->back()->with('error', 'Documento no encontrado.');
        }

    }

}
