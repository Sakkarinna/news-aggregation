<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;
use Carbon\Carbon;
use App\Models\Category;

class ArticleFeed extends Component
{
    public $articles = []; // Stores visible articles
    public $page = 1;      // Current pagination page
    public $hasMore = true; // Determines if there are more articles to load
    public $categories = [];

    protected $listeners = ['filterArticles'];

    public function mount()
    {
        $this->categories = Category::all(); // Fetch all categories
        $this->loadArticles(); // Load initial articles
    }

    public function loadMore()
    {
        $this->page++;

        // Load more articles and append them to the existing list
        $this->loadArticles();
    }

    public function loadArticles()
    {
        $newArticles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'page', $this->page);

        $this->articles = array_merge($this->articles, $newArticles->items());

        if ($newArticles->currentPage() >= $newArticles->lastPage()) {
            $this->hasMore = false;
        }
    }

    public function filterArticles($query, $category, $startDate, $endDate)
    {
        $queryBuilder = Article::with('user');

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                  ->orWhere('content', 'like', "%$query%")
                  ->orWhereHas('user', function ($q) use ($query) {
                      $q->where('name', 'like', "%$query%");
                  });
            });
        }

        if ($category) {
            $queryBuilder->where('category_id', $category);
        }

        if ($startDate) {
            $queryBuilder->whereDate('created_at', '>=', Carbon::parse($startDate));
        }

        if ($endDate) {
            $queryBuilder->whereDate('created_at', '<=', Carbon::parse($endDate));
        }

        $this->articles = $queryBuilder->orderBy('created_at', 'desc')->get();
    }


    public function render()
    {
        return view('livewire.article-feed');
    }
}
