<?php

namespace App\Livewire\DocumentosObras;

use App\Livewire\ServicesComponent;
use App\Models\DocumentoObra;
use Livewire\WithFileUploads;
use App\Models\TipoDocumentoObra;
use Illuminate\Support\Facades\Auth;

class CrearDocumentoObra extends ServicesComponent
{
    use WithFileUploads;
    public $nombre, $idObra,$idTipoDocumento, $path,$documento;
    public $showModal = false;
    #select unidades
    public $tiposDocumento;
    public $tipoDocumentoSeleccionado;

    public function mount($id)
    {
        $this->idObra = $id;
        $this->tiposDocumento = TipoDocumentoObra::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->tiposDocumento = TipoDocumentoObra::orderBy('nombre', 'asc')->get();
        return view('livewire.documentos-obras.crear-documento-obra');
    }

    public function crearDocumentoObra()
    {

        $this->validate([
            'nombre' => 'required|string',
            'documento' => 'required|file|max:10240', // max 10MB
            'tipoDocumentoSeleccionado' =>'required|exists:tipodocumentoobra,id',
        ]);
        try{
            $user = Auth::user();
            // Guardar el archivo en el sistema de archivos
            $path = $this->documento->store('documentos_obra');
            DocumentoObra::crearDocumentoObra($this->nombre, $path,$this->tipoDocumentoSeleccionado, $this->idObra, $user->id);
            $this->dispatch('refreshDocumentosObrasTable')->to(DocumentosObrasTable::class);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Documento cargado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al actualizar el Banco');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function limpiar()
    {
        $this->reset('nombre');
        $this->reset('path');
        $this->reset('tipoDocumentoSeleccionado');
        $this->documento = null;
        $this->closeModal();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
}
