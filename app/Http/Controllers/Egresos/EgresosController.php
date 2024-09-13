<?php

namespace App\Http\Controllers\Egresos;

use App\Http\Controllers\Controller;
use App\Models\Egreso;
use Barryvdh\DomPDF\Facade\Pdf;

class EgresosController extends Controller
{
    public function index()
    {
        return view('main-page.egresos.EgresosMain');
    }

    public static function pdfRecibo()
    {

       // try {
           // $egreso = Egreso::find($id);

//, compact('invoice', 'user')
            $pdf = PDF::loadView('pdf.recibo.recibo');

            return $pdf->stream('pdfRecibo.pdf');
        // } catch (Exception $e) {
        //     Log::error('Error al generar el PDF de la factura: '.$e->getMessage());

        //     return redirect()->route('dashboard');
        // }
    }
}
