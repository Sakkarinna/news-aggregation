<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
    @livewireStyles
</head>

<body class="bg-gray-100 h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gray-800 text-white p-4 flex justify-between items-center">
        <a href="/">
            <img src="{{ asset('favicon.ico') }}" alt="Logo" class="h-8 w-8">
        </a>
        <h1 class="text-lg font-bold">Sakkarin News - Admin {{ auth()->user()->name }}</h1>
        <nav class="flex space-x-4">
            <div class="text-center mb-4">
                <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture"
                    class="w-12 h-12 rounded-full mx-auto border-2 border-blue-500">
            </div>
            <a href="{{ route('articles.index') }}" class="hover:underline">
                News
            </a>

            <a href="{{ route('api.news') }}" class="hover:underline">API News</a>
            <a href="{{ route('profile.show') }}" class="hover:underline">Profile</a>
            <a href="{{ route('logout') }}" class="hover:underline"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </header>

    <!-- Main Layout -->
    <div x-data="{ open: true }" class="flex flex-grow">
        <!-- Sidebar -->
        <aside :class="open ? 'w-64' : 'w-20'"
            class="bg-gray-800 text-gray-100 transition-all duration-300 flex-shrink-0">
            <div class="flex justify-between items-center p-4">
                <h1 x-show="open" class="text-lg font-bold tracking-wide">Admin Panel</h1>
                <button @click="open = !open" class="text-gray-300 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5" />
                    </svg>
                </button>
            </div>

            <nav class="mt-6 space-y-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center space-x-4 py-2 px-4 hover:bg-gray-700 transition rounded-md group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-gray-300 group-hover:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l1.5 2h15l1.5-2M10 21V9l6 12" />
                    </svg>
                    <span x-show="open"
                        class="text-sm font-medium text-gray-300 group-hover:text-white">Dashboard</span>
                </a>
                <a href="{{ route('categories.index') }}"
                    class="flex items-center space-x-4 py-2 px-4 hover:bg-gray-700 transition rounded-md group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-gray-300 group-hover:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 11H4m15.5 5a.5.5 0 0 0 .5-.5V8a1 1 0 0 0-1-1h-3.75a1 1 0 0 1-.829-.44l-1.436-2.12a1 1 0 0 0-.828-.44H8a1 1 0 0 0-1 1M4 9v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1h-3.75a1 1 0 0 1-.829-.44L9.985 8.44A1 1 0 0 0 9.157 8H5a1 1 0 0 0-1 1Z" />
                    </svg>
                    <span x-show="open"
                        class="text-sm font-medium text-gray-300 group-hover:text-white">Categories</span>
                </a>
                <a href="{{ route('articles.index') }}"
                    class="flex items-center space-x-4 py-2 px-4 hover:bg-gray-700 transition rounded-md group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-gray-300 group-hover:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 19V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v13H7a2 2 0 0 0-2 2Zm0 0a2 2 0 0 0 2 2h12M9 3v14m7 0v4" />
                    </svg>
                    <span x-show="open"
                        class="text-sm font-medium text-gray-300 group-hover:text-white">Articles</span>
                </a>
                <a href="{{ route('users.index') }}"
                    class="flex items-center space-x-4 py-2 px-4 hover:bg-gray-700 transition rounded-md group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6 text-gray-300 group-hover:text-white">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span x-show="open" class="text-sm font-medium text-gray-300 group-hover:text-white">Users</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow p-6">
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>
    {{-- <script src="/node_modules/simple-datatables/dist/simple-datatables.js" defer></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectionTable = document.getElementById("selection-table");
            if (selectionTable) {
                new simpleDatatables.DataTable(selectionTable);
            }
        });
    </script>

</html>

@livewireScripts
</body>

</html>
