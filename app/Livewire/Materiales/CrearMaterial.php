<?php

namespace App\Livewire\Materiales;

use App\Livewire\ServicesComponent;
use App\Livewire\Insumos\CrearInsumo;
use App\Models\Material;
use App\Models\Unidad;
use Illuminate\Support\Facades\Auth;
use phpseclib3\File\ASN1\Maps\Certificate;

class CrearMaterial extends ServicesComponent
{
    public $nombre, $precioNormal;
    public $showModal = false;
    #select unidades
    public $unidades;
    public $unidadSelected;
    #select materiales
    public $materiales;
    public $editarMaterialSelected;
    protected $listeners = ['actualizarUnidades' => 'actualizarUnidadesMaterial'];
    public function mount()
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
    }

    public function render()
    {
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        $this->materiales = Material::orderBy('nombre', 'asc')->get();
        return view('livewire.materiales.crear-material');
    }

    public function crearMaterial()
    {


        if (is_null($this->editarMaterialSelected)) {
            $this->validate([
                'nombre' => 'required|string|unique:material,nombre,NULL,id,deleted_at,NULL',
                'precioNormal' => 'required|numeric',
                'unidadSelected' => 'required|exists:unidad,id',
            ]);
        } else {
            $this->validate([
                'nombre' => 'required|string',
                'precioNormal' => 'required|numeric',
                'unidadSelected' => 'min:1|exists:unidad,id',
            ]);
        }
        try {
            $user = Auth::user();
            Material::crearEditarMaterial($this->editarMaterialSelected,$this->nombre, $this->precioNormal, $this->unidadSelected, $user->id);
            $this->render();
            $this->limpiar();
            $this->alertService->success($this, 'Material creado con éxito');
        } catch (\Exception $th) {
            $this->alertService->error($this, 'Error al crear el Material');
            $this->loggerService->logError($th->getMessage() . '\nTraza:\n' . $th->getTraceAsString());
        }
    }

    public function updatedEditarMaterialSelected($materialId)
    {
        if ($materialId) {
            $material = Material::find($materialId);
            if ($material) {
                $this->nombre = $material->nombre;
                $this->precioNormal = $material->precioNormal;
                $this->unidadSelected = $material->idUnidad; // Asegúrate de que `unidad_id` es el nombre correcto del campo
            }
        } else {
            $this->reset(['nombre', 'precioNormal', 'unidadSelected']);
        }
    }

    public function limpiar()
    {

        $this->reset(['nombre', 'precioNormal', 'unidadSelected', 'editarMaterialSelected']);
        $this->unidades = Unidad::orderBy('nombre', 'asc')->get();
        $materiales = Material::orderBy('nombre', 'asc')->get();
        $this->dispatch('actualizarMateriales', compact('materiales'));
        $this->dispatch('actualizarMateriales')->to(CrearInsumo::class);

    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function actualizarUnidadesMaterial()
    {
        $unidades =Unidad::orderBy('nombre', 'asc')->get();
        $this->dispatch('actualizarUnidadesMaterial', compact('unidades'));
    }

}
