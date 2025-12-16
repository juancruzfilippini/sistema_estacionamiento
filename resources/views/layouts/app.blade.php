<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <!-- Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema Estacionamiento</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.min.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body
    class="font-sans antialiased bg-slate-950 text-slate-100 bg-[radial-gradient(circle_at_20%_20%,rgba(99,102,241,0.25),transparent_25%),radial-gradient(circle_at_80%_0%,rgba(16,185,129,0.22),transparent_22%),radial-gradient(circle_at_40%_80%,rgba(236,72,153,0.2),transparent_28%)]">
    <div class="min-h-screen relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 mix-blend-screen opacity-40"
            style="background: conic-gradient(from 45deg at 10% 20%, rgba(56,189,248,0.3), rgba(59,130,246,0.2), rgba(244,114,182,0.2), rgba(74,222,128,0.25), rgba(56,189,248,0.3)); filter: blur(90px);"></div>
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="relative z-10">
            <div class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        class="rounded-3xl border border-white/30 bg-white/80 text-slate-900 backdrop-blur-2xl shadow-2xl shadow-cyan-900/25 p-6 sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>


</html>
