<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KajianApp')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-green-50 font-sans text-gray-800 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-green-700 text-white px-6 py-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-semibold text-xl">
                <img src="https://img.icons8.com/color/48/mosque.png" class="h-8 w-8" alt="Mosque Icon" />
                <span class="ml-2 font-semibold text-xl">Sistem Kajian</span>
            </a>
            <div>
                <a href="{{ route('dashboard.kajian') }}" class="text-sm hover:underline">Home</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto w-full py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm py-4 bg-green-700 text-white">
        &copy; {{ date('Y') }} KajianApp. Untuk umat, dari umat.
    </footer>

</body>

</html>
