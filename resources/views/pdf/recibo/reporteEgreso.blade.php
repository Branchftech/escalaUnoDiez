<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Egresos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>


    @if($mensaje)
        <p>{{ $mensaje }}</p>
    @else
        <p style="text-align:right"><strong>Obra:</strong> {{ $egresos->first()->obra->detalle->nombreObra }}</p>
        <p style="text-align:right"><strong>Proveedor:</strong> {{ $egresos->first()->proveedor->nombre }}</p>
        <p style="text-align:right"><strong>Servicio:</strong> {{ $egresos->first()->servicios->first()->nombre }}</p>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($egresos as $egreso)
                    <tr>
                        <td>{{ $egreso->fecha }}</td>
                        <td>{{ $egreso->concepto }}</td>
                        <td>${{ $egreso->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Tabla de Destajos -->
       <br><br>
        <table style="background-color: #dff3f5;">
            <tbody>
                <tr>
                    <td style="text-align: right;">Presupuesto</td>
                    <td style="text-align: right;">${{ $destajo->presupuesto  }}</td> <!-- Puedes ajustar esta línea según el dato específico -->
                </tr>
                <tr>
                    <td style="text-align: right;">Total Pagado</td>
                    <td style="text-align: right;">${{ $totalPagado }}</td> <!-- Ajusta el valor según lo que necesites -->
                </tr>
                <tr>
                    <td style="text-align: right;">Saldo a Pagar</td>
                    <td style="text-align: right;">${{ $saldoAPagar }}</td> <!-- Ajusta el valor según lo que necesites -->
                </tr>
            </tbody>
        </table>

    @endif
</body>
</html>
