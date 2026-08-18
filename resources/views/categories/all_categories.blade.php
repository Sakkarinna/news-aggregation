@extends('layouts.admin_dashboard_layout')

@section('title', 'All Categories')

@section('content')
<div class="container mx-auto mt-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Categories</h1>
        <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Create Category
        </a>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table id="selection-table" class="min-w-full divide-y divide-gray-300 table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
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
                            Description
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
                @foreach($categories as $category)
                <tr class="hover:bg-gray-50 cursor-pointer">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('categories.edit', $category->id) }}" class="inline-block bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition mr-2">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-block bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition"
                                onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
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
        const selectionTable = document.getElementById("selection-table");
        if (selectionTable) {
            const dataTable = new simpleDatatables.DataTable(selectionTable, {
                searchable: true,
                perPage: 10, // Number of rows per page
                labels: {
                    searchPlaceholder: "Search categories...",
                    perPage: "{select} results per page",
                    noRows: "No categories found",
                    info: "Showing {start} to {end} of {rows} entries",
                    pagination: {
                        previous: "&lt;",
                        next: "&gt;"
                    }
                }
            });

            // Ensure that search function works for both "Name" and "Description"
            const searchWrapper = dataTable.wrapper.querySelector('.dataTable-input');
            if (searchWrapper) {
                const searchContainer = document.querySelector('.dataTable-search-wrapper');
                if (searchContainer) {
                    searchContainer.appendChild(searchWrapper);
                }
                searchWrapper.classList.add('mb-4', 'w-full');
                searchWrapper.style.marginRight = "auto"; // Align search to the left
            }
        }
    });
</script>

@endsection
