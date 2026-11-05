<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Akademik</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">

    <!-- Optional: Custom Dark Theme -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#DAB36E',
                        darkbg: '#052649'
                    }
                }
            }
        }
    </script>

</head>
<body class="bg-slate-900 text-slate-100">

<div class="flex">

    @include('components.sidebar')

    <div class="flex-1 ml-0 md:ml-64 min-h-screen">

        @include('components.header')

        <main class="md:p-8">
            @yield('content')
        </main>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
flatpickr("#tanggal_lahir", {
    dateFormat: "d/m/Y",
    locale: "id",
    allowInput: true,
    disableMobile: true
});
</script>

</body>
</html>