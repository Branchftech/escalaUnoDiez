<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 600px;
            border: 1px solid black;
            padding: 20px;
            margin: 0 auto;
        }
        .header {
            width: 100%;
            overflow: hidden; /* Asegura que los elementos flotados se contengan dentro del contenedor */
            border-bottom: 1px solid black;
            padding-bottom: 10px;
        }
        .logo {
            float: left; /* Alinea la imagen a la izquierda */
            width: 200px;
            height: 130px;
        }
        .title {
            display: inline-block;
            font-size: 5px;
            font-weight: bold;
            color: rgb(49, 1, 153)
            line-height: 100px; /* Alinea verticalmente el texto con la imagen */
            text-align: center;
             /* Restamos el ancho del logo y un pequeño margen */
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            font-size: 18px;
        }
        .amount {
            color: red;
            font-size: 20px;
            font-weight: bold;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid black;
            width: 200px;
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="" style=" display: inline-block;">
            <!-- Logo alineado a la izquierda -->
            <img src="{{ public_path('assets/images/logo.jpg') }}" alt="Logo" class="logo" >
            <span style="font-size: 50px; font-weight: bold; color: blue; line-height: 100px;">RECIBO</span>

        </div>

        <div class="details">
            <p style="text-align: right">Querétaro, Qro a {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
            <p style="text-align: right">Cantidad: <span class="amount">${{ $egreso->cantidad }}</span></p>
            <p style="text-align: right">Son {{ $egreso->cantidad_letras }} m.n</p>
            <p>A favor de: <span style="color: red;">{{ $egreso->proveedor->nombre }}</span></p>
            <p>Concepto de Pago: {{ $egreso->concepto }}</p>
            <p>Obra: <span style="color: red;">{{ $egreso->obra->detalle->nombreObra }}</span></p>
        </div>

        <div class="signature">
            <div class="signature-line">Firma de recibido</div>
        </div>
    </div>
</body>
</html>
