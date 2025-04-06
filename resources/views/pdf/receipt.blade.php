<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            color: #000;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .info-table th {
            background-color: #e0e0e0;
            font-weight: bold;
        }

        .amount {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            border: 2px solid #000;
            border-radius: 5px;
            background: #f8f8f8;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            padding-top: 10px;
            border-top: 2px solid #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- ENCABEZADO -->
        <div class="header">
            <h2>Recibo de Pago</h2>
            <p><strong>Fecha de pago:</strong> {{ $payment->created_at->format('d/m/Y') }}</p>
        </div>

        <!-- INFORMACIÓN DEL CLIENTE Y VEHÍCULO -->
        <table class="info-table">
            <tr>
                <th>Cliente</th>
                <td>{{ $payment->client->name }} {{ $payment->client->last_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $payment->client->email }}</td>
            </tr>
            <tr>
                <th>Mes de pago</th>
                <td>{{ $payment->billing_month }}</td>
            </tr>
            <tr>
                <th>Vehículo</th>
                <td>{{ $payment->vehicle->brand->name }} - {{ $payment->vehicle->model->name }} - {{ $payment->vehicle->patent }}</td>
            </tr>
            <tr>
                <th>Método de Pago</th>
                <td>{{ ucfirst($payment->type) }}</td>
            </tr>
        </table>

        <!-- MONTO PAGADO DESTACADO -->
        <div class="amount">
            Monto Pagado: ${{ number_format($payment->amount, 2, ',', '.') }}
        </div>

        <!-- PIE DE PÁGINA -->
        <div class="footer">
            <p><strong>Gracias por su pago.</strong> Para cualquier consulta, contáctenos.</p>
            <p><strong>Estacion Filippini S.R.L.</strong> | Email: estacionamiento.filippini@gmail.com</p>
            <p><strong>Comprobante Interno,</strong> no valido como factura.</p>
        </div>
    </div>
</body>

</html>
