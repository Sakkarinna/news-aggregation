<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">News</h1>
        <a href="{{ route('articles.create') }}"
            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Create News</a>
    </div>

    <!-- Search Bar -->
    <div class="mb-4 flex flex-col md:flex-row gap-4 items-start">
        <!-- Title, Author, and Content Search -->
        <input type="text" id="search-query"
            class="w-full md:w-1/3 p-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500"
            placeholder="Search by title, author, or content...">

        <!-- Category Dropdown -->
        <select id="category-filter"
            class="w-full md:w-1/4 p-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <!-- Date Range Filters -->
        <input type="date" id="start-date"
            class="w-full md:w-1/4 p-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500">
        <input type="date" id="end-date"
            class="w-full md:w-1/4 p-2 rounded border border-gray-300 focus:outline-none focus:border-blue-500">

        <!-- Search Button -->
        <button id="search-button" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">Search</button>
    </div>

    <div id="articles-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @if (count($articles) > 0)
            @foreach ($articles as $article)
                <div class="bg-white p-3 shadow-md rounded-md hover:shadow-lg transition-shadow duration-300">
                    <!-- Article Image -->
                    @if ($article['pic_path'])
                        <img src="{{ asset('storage/' . $article['pic_path']) }}"
                            class="w-full h-32 object-cover rounded-md" alt="Article Image">
                    @elseif ($article['pic_url'])
                        <img src="{{ $article['pic_url'] }}" class="w-full h-32 object-cover rounded-md"
                            alt="Article Image">
                    @endif

                    <!-- Author Profile -->
                    <div class="flex items-center mt-3">
                        <img src="{{ $article->user->profile_picture ?? asset('images/default-profile.png') }}"
                            alt="{{ $article->user->name }}'s profile picture" class="w-8 h-8 rounded-full border mr-3">
                        <p class="text-sm text-gray-600 font-semibold">{{ $article->user->name }}</p>
                    </div>

                    <!-- Article Details -->
                    <div class="mt-3">
                        <h5 class="text-md font-semibold">{{ $article['title'] }}</h5>
                        <p class="text-sm text-gray-600 line-clamp-2 mt-2">{{ Str::limit($article['content'], 70) }}</p>
                        <a href="{{ route('articles.show', $article['id']) }}"
                            class="bg-blue-500 text-white text-sm px-3 py-1 rounded mt-3 inline-block hover:bg-blue-600">Read
                            More</a>
                    </div>
                </div>
            @endforeach

            <div wire:loading>
                <p class="text-center text-info">Loading more articles...</p>
            </div>
            <p class="text-center text-muted mt-4" wire:loading.remove>
                @if (!$hasMore)
                    No more news to load.
                @endif
            </p>
        @else
            <p class="text-center text-gray-600">No articles available at the moment.</p>
        @endif
    </div>
</div>

<script>
    let timeout;

    // Infinite Scroll
    document.addEventListener('scroll', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100) {
                console.log('Scrolled to bottom');
                @this.call('loadMore');
            }
        }, 150);
    });

    // Search Functionality
    document.getElementById('search-input').addEventListener('input', function() {
        let searchValue = this.value.toLowerCase();
        let articles = document.querySelectorAll('#articles-container > div');

        articles.forEach(function(article) {
            let author = article.querySelector('.mt-3 p:nth-of-type(2)').textContent.toLowerCase();
            let title = article.querySelector('h5').textContent.toLowerCase();
            let content = article.querySelector('.line-clamp-2').textContent.toLowerCase();

            if (author.includes(searchValue) || title.includes(searchValue) || content.includes(
                    searchValue)) {
                article.style.display = "block";
            } else {
                article.style.display = "none";
            }
        });
    });

    // Search Button
    document.addEventListener('DOMContentLoaded', function () {
    const searchButton = document.getElementById('search-button');
    if (searchButton) {
        searchButton.addEventListener('click', function () {
            const query = document.getElementById('search-query').value.toLowerCase();
            const category = document.getElementById('category-filter').value;
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            Livewire.emit('filterArticles', query, category, startDate, endDate);
        });
    }
});

</script>
