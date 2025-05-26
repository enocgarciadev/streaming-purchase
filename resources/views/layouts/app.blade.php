<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN (opcional para estilos modernos rápidos) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col">
            @include('partials.navbar')

            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
