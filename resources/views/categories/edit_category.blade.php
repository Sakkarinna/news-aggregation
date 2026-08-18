@extends('layouts.admin_dashboard_layout')

@section('title', 'Edit Category')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Edit Category</h1>
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Category Name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" id="name" name="name" value="{{ $category->name }}"
                           class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Enter category name" required>
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Enter category description">{{ $category->description }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
