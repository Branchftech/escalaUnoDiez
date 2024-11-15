<?php

namespace App\Livewire\Reportes;

use App\Livewire\ServicesComponent;
use App\Models\Egreso;
use App\Models\Obra;
use App\Models\Proveedor;
use App\Models\FormaPago;
use App\Models\Banco;
use App\Models\Servicio;
use App\Models\Destajo;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class EgresoReporte extends ServicesComponent
{

    #selects para el reporte
    public $obras;
    public $obrasReporte;
    public $obraReporteSeleccionado;
    public $proveedores;
    public $proveedoresReporte;
    public $proveedorReporteSeleccionado;
    public $servicios;
    public $serviciosReporte;
    public $serviciosReporteSeleccionados = [];
    public $destajos;
    public $destajosReporte;
    public $destajoReporteSeleccionado;

    public function mount()
    {
        $this->obras = Obra::all();
        $this->obrasReporte = $this->obras;
        $this->destajos = Destajo::whereHas('obra', function ($query) {
            $query->whereNull('deleted_at');
        })->with('obra')->get();
        $this->destajosReporte = $this->destajos;
        $this->proveedores = Proveedor::all();
        $this->proveedoresReporte = $this->proveedores;
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();
        $this->serviciosReporte = Servicio::orderBy('nombre', 'asc')->get();
    }


    public function render()
    {
        $this->obras = Obra::all();
        $this->obrasReporte = $this->obras;
        $this->destajos = Destajo::whereHas('obra', function ($query) {
            $query->whereNull('deleted_at');
        })->with('obra')->get();
        $this->destajosReporte = $this->destajos;
        $this->proveedores = Proveedor::all();
        $this->proveedoresReporte = $this->proveedores;
        $this->servicios = Servicio::orderBy('nombre', 'asc')->get();
        $this->serviciosReporte = Servicio::orderBy('nombre', 'asc')->get();

        return view('livewire.reportes.egreso-reporte');
    }
}
