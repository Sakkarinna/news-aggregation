@php
    $layout = auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin_dashboard_layout' : 'layouts.layout';
@endphp

@extends($layout)

@section('title', $article->title)

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
        <!-- Article Title and Author Info -->
        <div class="mb-6">
            <h1 class="text-4xl font-bold mb-2">{{ $article->title }}</h1>
            <div class="flex items-center space-x-4">
                <!-- Author's Profile Picture -->
                <img src="{{ $article->user->profile_picture ?? asset('images/default-profile.png') }}"
                    alt="{{ $article->user->name }}'s profile picture" class="w-12 h-12 rounded-full border">
                <div>
                    <!-- Author's Name -->
                    <p class="text-sm text-gray-500">
                        By
                        @if ($article->user->name === 'Anonymous')
                            <span class="text-gray-400">{{ $article->user->name }}</span>
                        @else
                            <a href="{{ route('profile.others', $article->user->id) }}"
                                class="text-blue-600 hover:underline">
                                {{ $article->user->name }}
                            </a>
                        @endif
                    </p>

                    <p class="text-xs text-gray-400">Published: {{ $article->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="text-base text-gray-700 leading-relaxed mb-6">
            {{ $article->content }}
        </div>

        <!-- Article Image Section -->
        @if ($article->pic_path)
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $article->pic_path) }}" class="w-full max-w-md h-auto rounded-lg shadow-md"
                    alt="Article Image">
            </div>
        @endif

        <!-- Video Section -->
        @if ($article->vid_path)
            <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-6 flex justify-center">
                <div class="w-full max-w-lg">
                    <h2 class="text-lg font-semibold mb-4 text-center">Watch Related Video</h2>
                    <video controls class="w-full rounded-lg shadow-sm">
                        <source src="{{ asset('storage/' . $article->vid_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        @endif

        <!-- Actions Section -->
        <div class="flex flex-wrap gap-4 mb-6">
            <!-- Like Button -->
            <form action="{{ route('like', ['type' => 'article', 'id' => $article->id]) }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                    Like ({{ $article->likes->count() }})
                </button>
            </form>

            <!-- Follow Author Button -->
            <form action="{{ route('follow', ['type' => 'user', 'id' => $article->user->id]) }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    {{ auth()->user() &&auth()->user()->followings()->where('followable_id', $article->user->id)->where('followable_type', 'App\\Models\\User')->exists()? 'Unfollow Author': 'Follow Author' }}
                </button>
            </form>

            <!-- Follow Article Button -->
            <form action="{{ route('follow', ['type' => 'article', 'id' => $article->id]) }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    {{ auth()->user() &&auth()->user()->followedArticles()->where('followable_id', $article->id)->exists()? 'Unfollow Article': 'Follow Article' }}
                </button>
            </form>

            <!-- Edit and Delete Buttons (only for the author) -->
            @if (auth()->check() && auth()->id() == $article->user_id)
                <div class="flex gap-2">
                    <a href="{{ route('articles.edit', ['article' => $article->id]) }}"
                        class="px-6 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">Edit</a>
                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition"
                            onclick="return confirm('Are you sure you want to delete this article?');">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Comment Section -->
        <div class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-semibold mb-4">Add a Comment</h2>
            @auth
                <form action="{{ route('comments.store', $article->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <textarea name="content" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        rows="4" placeholder="Write your comment..." required></textarea>
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Post
                        Comment</button>
                </form>
            @else
                <p>Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> to add a comment.</p>
            @endauth
        </div>

        <!-- Comments List -->
        <div class="mt-8">
            <h3 class="text-2xl font-bold mb-6">Comments ({{ $comments->count() }})</h3>
            @foreach ($comments->sortByDesc('likes_count') as $comment)
                <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                    <div class="flex items-start space-x-4">
                        <!-- Comment Author Profile Picture -->
                        <img src="{{ $comment->user->profile_picture ?? asset('images/default-profile.png') }}"
                            alt="{{ $comment->user->name }}'s profile picture" class="w-12 h-12 rounded-full border">
                        <div>
                            <!-- Comment Content -->
                            <p class="text-gray-800">{{ $comment->content }}</p>
                            <!-- Comment Author Name and Time -->
                            <p class="text-xs text-gray-500 mt-2">
                                By
                                <a href="{{ route('profile.others', $comment->user->id) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $comment->user->name }}
                                </a>
                                - {{ $comment->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <!-- Like Button -->
                    <div class="mt-4">
                        <form action="{{ route('like', ['type' => 'comment', 'id' => $comment->id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                Like ({{ $comment->likes->count() }})
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
