<?php

// namespace App\Livewire\DetallesObras;

// use Livewire\Component;
// use Illuminate\Support\Facades\Http;
// use App\Models\DetalleObra;

// class DetallesObrasTable extends Component
// {
//     public $model;
//     public $calle,$manzana,$lote,$metrosCuadrados,$fraccionamiento, $lat, $lng;

//     public $listeners = ['cargarCroquis'];

//     public function mount()
//     {
//         $this->model = DetalleObra::find(3);
//         $this->calle = $this->model->calle;
//         $this->manzana = $this->model->manzana;
//         $this->lote = $this->model->lote;
//         $this->metrosCuadrados = $this->model->metrosCuadrados;
//         $this->fraccionamiento = $this->model->fraccionamiento;
//         $this->geocodeAddress();
//     }
//     public function geocodeAddress()
//     {
//         $direccion = "$this->calle, $this->manzana $this->lote, Ciudad de México, Ciudad de México, México";
//         $direccion = urlencode($direccion);
//         $googleApiKey = 'AIzaSyDgBbIyOuTgm46knJQP8-oOcV-NybkOyuc';

//         $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$direccion}&key={$googleApiKey}";

//         $response = file_get_contents($url);
//         $responseData = json_decode($response, true);

//         if ($responseData['status'] === 'OK') {
//             $this->lat = $responseData['results'][0]['geometry']['location']['lat'];
//             $this->lng = $responseData['results'][0]['geometry']['location']['lng'];
//         } else {
//             $this->lat = null;
//             $this->lng = null;
//         }
//     }

//     public function render()
//     {
//         return view('livewire.detalles-obras.detalles-obras-table', [
//             'lat' => $this->lat,
//             'lng' => $this->lng
//         ]);
//     }
// }

namespace App\Livewire\DetallesObras;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use App\Models\DetalleObra;
use GuzzleHttp\Client;

class DetallesObrasTable extends Component
{
    public $model;
    public $calle, $manzana, $lote, $metrosCuadrados, $fraccionamiento, $lat, $lng;

    public $listeners = ['cargarCroquis'];

    public function mount()
    {
        $this->model = DetalleObra::find(3);
        $this->calle = $this->model->calle;
        $this->manzana = $this->model->manzana;
        $this->lote = $this->model->lote;
        $this->metrosCuadrados = $this->model->metrosCuadrados;
        $this->fraccionamiento = $this->model->fraccionamiento;
        $this->geocodeAddress();
    }

    public function geocodeAddress()
    {
        $direccion = "$this->calle, $this->manzana $this->lote, Ciudad de México, Ciudad de México, México";
        $client = new Client();

        try {
            $response = $client->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $direccion,
                    'format' => 'json',
                    'limit' => 1
                ],
                'headers' => [
                    'User-Agent' => 'YourAppName/1.0 (your@email.com)'  // Reemplaza con tu correo y nombre de app
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

