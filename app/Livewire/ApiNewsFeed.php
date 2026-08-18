<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ApiNewsFeed extends Component
{
    public $newsArticles = [];
    public $searchQuery = '';
    public $fromDate = '';
    public $toDate = '';
    public $page = 1;
    public $hasMore = true;

    public function mount()
    {
        // Load the initial set of articles
        $this->loadArticles();
    }

    public function loadMore()
    {
        $this->page++;
        $this->loadArticles();
    }

    public function filterArticles($query, $from, $to)
    {
        $this->searchQuery = $query;
        $this->fromDate = $from;
        $this->toDate = $to;
        $this->page = 1; // Reset pagination
        $this->newsArticles = [];
        $this->loadArticles();
    }

    public function loadArticles()
    {
        $apiKey = config('services.newscatcher.api_key');
        $apiUrl = 'https://api.newscatcherapi.com/v2/search';
        $queryParams = [
            'countries' => 'US',
            'topic' => 'tech',
            'q' => $this->searchQuery,
            'from' => $this->fromDate,
            'to' => $this->toDate,
            'page' => $this->page,
        ];

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->get($apiUrl, $queryParams);

        if ($response->successful()) {
            $newArticles = $response->json()['articles'] ?? [];
        } else {
            $newArticles = [];
        }

        $this->newsArticles = array_merge($this->newsArticles, $newArticles);

        if (count($newArticles) === 0) {
            $this->hasMore = false;
        }
    }



    public function render()
    {
        return view('livewire.api-news-feed');
    }
}
