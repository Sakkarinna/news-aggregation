@extends('layouts.admin_dashboard_layout')

@section('title', 'All Users')

@section('content')
<div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">All Users</h1>
        <a href="{{ route('users.register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Register User
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table id="users-table" class="min-w-full divide-y divide-gray-300 table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-600 tracking-wider">
                        <span class="flex items-center">
                            ID
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 15l4 4 4-4M16 9l-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-600 tracking-wider">
                        <span class="flex items-center">
                            Name
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 15l4 4 4-4M16 9l-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-600 tracking-wider">
                        <span class="flex items-center">
                            Email
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 15l4 4 4-4M16 9l-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-bold text-gray-600 tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    @if(!\DB::table('deleted_users')->where('email', $user->email)->exists())
                    <tr class="hover:bg-gray-50 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-block bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition"
                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>

        </table>
    </div>
</div>

<!-- Include Simple-DataTables -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" defer></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const usersTable = document.getElementById("users-table");
        if (usersTable) {
            const dataTable = new simpleDatatables.DataTable(usersTable, {
                searchable: true,
                perPage: 10,
                labels: {
                    searchPlaceholder: "Search users...",
                    perPage: "{select} results per page",
                    noRows: "No users found",
                    info: "Showing {start} to {end} of {rows} entries",
                    pagination: {
                        previous: "&lt;",
                        next: "&gt;"
                    }
                }
            });

            // Move the search bar to the custom wrapper
            const searchWrapper = dataTable.wrapper.querySelector('.dataTable-input');
            if (searchWrapper) {
                const searchContainer = document.querySelector('.dataTable-search-wrapper');
                if (searchContainer) {
                    searchContainer.appendChild(searchWrapper);
                }
                searchWrapper.classList.add('mb-4', 'w-full');
                searchWrapper.style.marginRight = "auto";
            }
        }
    });
</script>

@endsection
