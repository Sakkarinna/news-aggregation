@php
    $layout = auth()->check() && auth()->user()->role === 'admin'
        ? 'layouts.admin_dashboard_layout'
        : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-bold mb-6">Edit Article</h1>

        <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" value="{{ $article->title }}" required>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Select Category</label>
                <select id="category" name="category_id" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" required>
                    <option value="" disabled>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea id="content" name="content" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" rows="6" required>{{ $article->content }}</textarea>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" accept="image/*">
                @if ($article->pic_path)
                    <img src="{{ asset('storage/' . $article->pic_path) }}" alt="Current Image" class="w-full mt-4 rounded-md">
                @endif
            </div>

            <!-- Video Upload -->
            <div>
                <label for="video" class="block text-sm font-medium text-gray-700 mb-1">Upload Video</label>
                <input type="file" id="video" name="video" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" accept="video/*">
                @if ($article->vid_path)
                    <video controls class="w-full mt-4 rounded-md">
                        <source src="{{ asset('storage/' . $article->vid_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Update Article</button>
            </div>
        </form>
    </div>
@endsection
