<x-app-layout>
    <div class="container" style="margin-bottom: 550px">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="mb-4">Registrar Pago</h1>

                <!-- Mensajes de error y éxito -->
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Formulario para registrar el pago -->
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf

                    <!-- Selección de Cliente -->
                    <div class="mb-3">
                        <select class="form-select select2" name="client_id" id="client_id" required
                            style="height: 2.5rem;">
                            <option value="">Seleccione un Cliente</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">
                                    {{ $client->name }} {{ $client->last_name }} - {{ $client->email ?: 'Sin mail registrado' }}
                                </option>
                            @endforeach
                        </select>


                    </div>

                    <!-- Selección de Vehículo -->
                    <div class="mb-3" id="vehicle-container" style="display: none;">
                        <select class="form-select" name="vehicle_id" id="vehicle_id" required>
                            <option value="">Seleccione un Vehículo</option>
                        </select>
                    </div>

                    <!-- Selección de Año -->
                    <div class="mb-3" id="year-container" style="display: none;">
                        <select class="form-select" name="billing_year" id="billing_year" required>
                            <option value="">Seleccione el Año</option>
                        </select>
                    </div>

                    <!-- Selección de Mes -->
                    <div class="mb-3" id="month-container" style="display: none;">
                        <select class="form-select" name="billing_month" id="billing_month" required>
                            <option value="">Seleccione el Mes</option>
                        </select>
                    </div>



                    <!-- Tarifa del Vehículo -->
                    <div class="mb-3" id="amount-container" style="display: none;">
                        <div id="amount-display"
                            class="text-2xl font-bold bg-green-100 text-green-700 p-4 rounded-lg shadow-md">
                            $0.00
                        </div>
                    </div>

                    <!-- Switch para aplicar recargo -->
                    <div class="mb-3" id="surcharge-container" style="display: none;">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="surcharge-switch">
                            <label class="form-check-label" for="surcharge-switch">RECARGO DEL 10%</label>
                        </div>
                    </div>

                    <div class="mb-3" id="send-mail-container" style="display: none;">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="send-mail-switch" name="send_mail"
                                value="1">
                            <label class="form-check-label" for="send-mail-switch">ENVIAR RECIBO POR MAIL</label>
                        </div>
                    </div>


                    <!-- Tarifa del Vehículo (input oculto) -->
                    <div class="mb-3" id="amount-hidden-container" style="display: none;">
                        <input type="number" step="0.01" class="form-control" style="display: none;" name="amount"
                            id="amount" required readonly>
                    </div>

                    <!-- Tipo de Pago -->
                    <div class="mb-3">
                        <select class="form-select" name="type" id="type" required>
                            <option value="">Seleccione un Método de Pago</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="mercadopago">MercadoPago</option>
                            <option value="qr">QR</option>
                            <option value="efectivo">Efectivo</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Generar Pago</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Agregar CSS de Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Agregar JS de Select2 y jQuery (si aún no lo tienes) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <!-- AJAX para cargar vehículos y tarifas -->
    <script>
        $(document).ready(function() {
            let baseAmount = 0; // Monto base sin recargo

            // Inicializar Select2
            $('#client_id').select2({
                placeholder: "Seleccione un Cliente",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                }
            });

            // Evento de cambio en el select de clientes (compatible con Select2)
            $('#client_id').on('change', function() {
                let clientId = $(this).val();
                let vehicleSelect = $('#vehicle_id');
                let vehicleContainer = $('#vehicle-container');
                let amountContainer = $('#amount-container');
                let surchargeContainer = $('#surcharge-container');
                let amountInput = $('#amount');

                // Limpiar selects anteriores
                vehicleSelect.html('<option value="">Seleccione un Vehículo</option>');
                amountInput.val('');
                baseAmount = 0;

                if (clientId) {
                    fetch(`/sistema_estacionamiento/public/vehicles-by-client/${clientId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.vehicles.length > 0) {
                                vehicleContainer.show();
                                data.vehicles.forEach(vehicle => {
                                    let option = new Option(
                                        `${vehicle.brand.name} - ${vehicle.model.name} - ${vehicle.patent}`,
                                        vehicle.id
                                    );
                                    vehicleSelect.append(option);
                                });
                            } else {
                                vehicleContainer.hide();
                            }
                        });
                } else {
                    vehicleContainer.hide();
                    amountContainer.hide();
                    surchargeContainer.hide();
                }
            });


            // Evento de cambio en el select de vehículos
            $('#vehicle_id').on('change', function() {
                let vehicleId = $(this).val();

                if (!vehicleId) return;

                fetch(`/sistema_estacionamiento/public/vehicle-tariff/${vehicleId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.tariff) {
                            baseAmount = parseFloat(data.tariff);
                            updateAmountDisplay();
                            $('#amount-container, #surcharge-container, #amount-hidden-container')
                                .show();
                        } else {
                            console.error('Tarifa no encontrada');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // Detectar cambio en el switch de recargo
            $('#surcharge-switch').on('change', function() {
                updateAmountDisplay();
            });

            function updateAmountDisplay() {
                let surchargeSwitch = $('#surcharge-switch').prop('checked');
                let finalAmount = surchargeSwitch ? baseAmount * 1.10 : baseAmount;

                let formattedAmount = new Intl.NumberFormat('es-CL', {
                    style: 'currency',
                    currency: 'CLP'
                }).format(finalAmount);

                $('#amount-display').text(formattedAmount);
                $('#amount').val(finalAmount.toFixed(2));
            }
        });

        // Evento de cambio en el select de vehículos
        $('#vehicle_id').on('change', function() {
            let vehicleId = $(this).val();
            let yearSelect = $('#billing_year');
            let monthSelect = $('#billing_month');
            let yearContainer = $('#year-container');
            let monthContainer = $('#month-container');

            if (!vehicleId) {
                yearContainer.hide();
                monthContainer.hide();
                return;
            }

            fetch(`/sistema_estacionamiento/public/vehicle-paid-months/${vehicleId}`)
                .then(response => response.json())
                .then(data => {
                    // Organizar por años
                    const currentYear = new Date().getFullYear();
                    let years = [];
                    for (let y = 2023; y <= currentYear + 1; y++) {
                        years.push(y);
                    }
                    yearSelect.html('<option value="">Seleccione el Año</option>');
                    years.forEach(year => {
                        yearSelect.append(new Option(year, year));
                    });

                    yearContainer.show();

                    // Guardar pagos para luego usar al seleccionar año
                    yearSelect.data('paidMonths', data.paidMonths);
                });
        });

        $('#billing_year').on('change', function() {
            const selectedYear = $(this).val();
            const paidMonths = $(this).data('paidMonths');
            const monthSelect = $('#billing_month');
            const monthContainer = $('#month-container');

            if (!selectedYear) {
                monthContainer.hide();
                return;
            }

            const monthNames = [
                'Enero', 'Febrero', 'Marzo', 'Abril',
                'Mayo', 'Junio', 'Julio', 'Agosto',
                'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];

            monthSelect.html('<option value="">Seleccione el Mes</option>');

            for (let i = 1; i <= 12; i++) {
                const formattedMonth = String(i).padStart(2, '0') + '-' + selectedYear;
                const isPaid = paidMonths.includes(formattedMonth);
                const display = `${monthNames[i - 1]}${isPaid ? ' ✅' : ''}`;
                monthSelect.append(new Option(display, formattedMonth));
            }

            monthContainer.show();
        });


        function maybeShowMailSwitch() {
            const vehicleId = $('#vehicle_id').val();
            if (vehicleId) {
                $('#send-mail-container').show();
            } else {
                $('#send-mail-container').hide();
            }
        }

        $('#vehicle_id, #billing_month').on('change', maybeShowMailSwitch);
    </script>
</x-app-layout>

<style>
    .select2-selection__rendered {
        height: 2.5rem !important;
        /* Altura del contenido */
        line-height: 2.5rem !important;
        /* Alinear el texto verticalmente */
    }

    .select2-selection {
        height: 2.5rem !important;
        /* Altura del select */
    }

    /* Ajustar altura y bordes para que coincida con otros inputs */
    .select2-container .select2-selection--single {
        height: 2.5rem !important;
        /* Ajusta la altura */
        border-radius: 0.375rem;
        /* Esquinas redondeadas */
        border: 1px solid #ccc;
        /* Borde del input normal */
        display: flex;
        align-items: center;
        /* Centra el texto verticalmente */
    }

    /* Ajustar el texto dentro del select2 */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2.5rem !important;
        padding-left: 0.75rem;
        font-size: 1rem;
    }

    /* Ajustar el icono del desplegable */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 2.5rem !important;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Color del placeholder en Select2 */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: black !important;
        /* Cambia el color del texto del placeholder */
        font-weight: normal;
        /* Opcional: ajustar el peso de la fuente */
    }
</style>
