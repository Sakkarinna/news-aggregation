@php
    $layout = auth()->check() && auth()->user()->role === 'admin'
        ? 'layouts.admin_dashboard_layout'
        : 'layouts.layout';
@endphp

@extends($layout)

@section('content')
    <div class="container mx-auto px-6 py-10">
        <!-- Profile Section -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-10">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
                    <p class="text-gray-500 mt-2">Member since: {{ $user->created_at->format('M d, Y') }}</p>
                </div>
                <div class="mt-6 md:mt-0">
                    <!-- Follow/Unfollow Button -->
                    <form action="{{ route('follow', ['type' => 'user', 'id' => $user->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-2 bg-blue-600 text-white rounded-full shadow-md hover:bg-blue-700 transition duration-300">
                            {{ auth()->user() && auth()->user()->followings()->where('followable_id', $user->id)->where('followable_type', 'App\\Models\\User')->exists() ? 'Unfollow User' : 'Follow User' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Articles Section -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $user->name }}'s Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $article)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    @if ($article->pic_path)
                        <img src="{{ asset('storage/' . $article->pic_path) }}" class="w-full h-56 object-cover" alt="Article Image">
                    @elseif ($article->pic_url)
                        <img src="{{ $article->pic_url }}" class="w-full h-56 object-cover" alt="Article Image">
                    @endif
                    <div class="p-6">
                        <h5 class="text-xl font-bold text-gray-800 mb-3">{{ $article->title }}</h5>
                        <p class="text-gray-600 mb-6">{{ Str::limit($article->content, 100) }}</p>
                        <a href="{{ route('articles.show', $article->id) }}" class="block w-max px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300">Read More</a>
                    </div>
                    <div class="bg-gray-100 px-6 py-4">
                        <small class="text-gray-500">{{ $article->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
