@php
    $layout = auth()->check() && auth()->user()->role === 'admin'
        ? 'layouts.admin_dashboard_layout'
        : 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'My Profile')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Edit Profile Button -->
        <div class="flex justify-start mb-6">
            <a
                href="{{ route('profile.edit') }}"
                class="mr-5 px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg shadow-md hover:from-green-600 hover:to-green-700 transition duration-200"
            >
                Edit Profile
            </a>
            <a
                href="{{ route('profile.get') }}"
                class="px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg shadow-md hover:from-green-600 hover:to-green-700 transition duration-200"
            >
                Get Profile
            </a>
        </div>

        <!-- Profile Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ auth()->user()->name }}</h1>
            <p class="mt-2 text-gray-600">Email: {{ auth()->user()->email }}</p>
            <p class="text-gray-500">Member since: {{ auth()->user()->created_at->format('M d, Y') }}</p>
        </div>

        <!-- Articles Section -->
        <h2 class="text-xl font-bold mb-4 text-gray-800">My Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    @if ($article->pic_path)
                        <img src="{{ asset('storage/' . $article->pic_path) }}" class="w-full h-48 object-cover" alt="Article Image">
                    @elseif ($article->pic_url)
                        <img src="{{ $article->pic_url }}" class="w-full h-48 object-cover" alt="Article Image">
                    @endif
                    <div class="p-4">
                        <h5 class="text-lg font-bold text-gray-800">{{ $article->title }}</h5>
                        <p class="text-gray-600">{{ Str::limit($article->content, 100) }}</p>
                        <a
                            href="{{ route('articles.show', $article->id) }}"
                            class="text-blue-500 hover:text-blue-600 hover:underline font-semibold"
                        >
                            Read More
                        </a>
                    </div>
                    <div class="flex items-center justify-between px-4 py-2 bg-gray-50">
                        <small class="text-gray-500">{{ $article->created_at->diffForHumans() }}</small>
                        <div class="flex items-center space-x-2">
                            <a
                                href="{{ route('articles.edit', $article->id) }}"
                                class="px-3 py-1 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 transition duration-200"
                            >
                                Edit
                            </a>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="px-3 py-1 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition duration-200"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
