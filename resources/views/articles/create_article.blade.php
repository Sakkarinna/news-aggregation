@php
    $layout = auth()->check() && auth()->user()->role === 'admin'
        ? 'layouts.admin_dashboard_layout'
        : 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'Create News')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold mb-6">Create News</h1>

        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <!-- Title Input -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Category Select -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Select Category</label>
                <select id="category" name="category_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                    <option value="" disabled selected>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Content Textarea -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea id="content" name="content" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" rows="6" required></textarea>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" accept="image/*" required>
            </div>

            <!-- Video Upload -->
            <div>
                <label for="video" class="block text-sm font-medium text-gray-700 mb-1">Upload Video</label>
                <input type="file" id="video" name="video" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" accept="video/*">
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Create</button>
            </div>
        </form>
    </div>
@endsection
