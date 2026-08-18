<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Layout')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
    @livewireStyles
</head>

<body class="bg-gray-100 h-screen flex flex-col">
    <!-- Navbar -->
    <header class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <!-- Logo and Title -->
        <div class="flex items-center space-x-2">
            <!-- Clickable Logo -->
            <a href="/">
                <img src="{{ asset('favicon.ico') }}" alt="Logo" class="h-8 w-8">
            </a>
            <h1 class="text-lg font-bold">Sakkarin News</h1>
        </div>

        <!-- Navigation -->
        <nav class="flex space-x-4">

            @auth
                <div class="text-center mb-4">
                    <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture"
                        class="w-12 h-12 rounded-full mx-auto border-2 border-blue-500">
                </div>
            @endauth
            <!-- API News Button -->
            <a href="{{ route('articles.index') }}" class="hover:underline">
                News
            </a>

            <a href="{{ route('api.news') }}" class="hover:underline">API News</a>

            @guest
                <!-- If the user is not logged in -->
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
                <a href="{{ route('register') }}" class="hover:underline">Register</a>
            @else
                <!-- If the user is logged in -->
                <a href="{{ route('profile.show') }}" class="hover:underline">Profile</a>
                <a href="{{ route('logout') }}" class="hover:underline"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </nav>
    </header>


    <!-- Main Content -->
    <main class="flex-grow p-6">
        @yield('content')
    </main>

    <!-- Include Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
    <script src="/node_modules/simple-datatables/dist/simple-datatables.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectionTable = document.getElementById("selection-table");
            if (selectionTable) {
                new simpleDatatables.DataTable(selectionTable);
            }
        });
    </script>
    @livewireScripts
</body>

</html>
