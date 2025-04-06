<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #2c3e50;">📄 Recibo de Pago</h2>
        <p>Hola {{ $client->name }} {{ $client->last_name }},</p>
        <p>Hemos recibido tu pago. Aquí están los detalles:</p>

        <h3>🔹 Información del Pago</h3>
        <ul>
            <li><strong>Monto:</strong> ${{ number_format($payment->amount, 2, ',', '.') }}</li>
            <li><strong>Fecha de pago:</strong> {{ $payment->created_at->format('d/m/Y') }}</li>
            <li><strong>Mes de pago:</strong> {{ $payment->billing_month }}</li>
            <li><strong>Método de Pago:</strong> {{ ucfirst($payment->type) }}</li>
        </ul>

        <h3>🚗 Datos del Vehículo</h3>
        <ul>
            <li><strong>Marca:</strong> {{ $vehicle->brand->name }}</li>
            <li><strong>Modelo:</strong> {{ $vehicle->model->name }}</li>
            <li><strong>Patente:</strong> {{ $vehicle->patent }}</li>
        </ul>

        <p style="margin-top: 20px;">Gracias por confiar en nuestro servicio. 📩</p>
        <p>Atentamente,</p>
        <p><strong>Sistema de Estacionamiento</strong></p>
    </div>
</body>
</html>
