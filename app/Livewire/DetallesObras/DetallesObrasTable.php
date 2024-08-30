<?php

namespace App\Livewire\DetallesObras;

use Livewire\Component;
use App\Models\DetalleObra;
use App\Models\Obra;
use GuzzleHttp\Client;

class DetallesObrasTable extends Component
{
    public $model;
    public $calle,$id, $manzana, $lote, $estado,$pais, $fraccionamiento, $lat, $lng;

    public $listeners = ['cargarCroquis'];

    public function mount($id)
    {
        $this->id= $id;
        $this->model = Obra::with('detalle')->find($id);
        $this->calle = $this->model->detalle->direccion->calle;
        $this->manzana = $this->model->detalle->direccion->manzana;
        $this->lote = $this->model->detalle->direccion->lote;
        $this->pais = $this->model->detalle->direccion->pais->nombre;
        $this->estado = $this->model->detalle->direccion->estado->nombre;
        $this->geocodeAddress();
    }

    public function geocodeAddress()
    {

        $direccion = "$this->calle, $this->estado, $this->pais";

        $client = new Client();

        try {
            $response = $client->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $direccion,
                    'format' => 'json',
                    'limit' => 1
                ],
                'headers' => [
                    'User-Agent' => 'YourAppName/1.0 (eunodiez@gmail.com)'  // Reemplaza con tu correo y nombre de app
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (!empty($responseData)) {
                $this->lat = $responseData[0]['lat'];
                $this->lng = $responseData[0]['lon'];
            } else {
                $this->lat = null;
                $this->lng = null;
            }

        } catch (\Exception $e) {
            $this->lat = null;
            $this->lng = null;
        }
    }

    public function render()
    {
        return view('livewire.detalles-obras.detalles-obras-table', [
            'lat' => $this->lat,
            'lng' => $this->lng
        ]);
    }
}

