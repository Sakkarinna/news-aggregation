<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function apiNews(Request $request)
{
    $apiKey = config('services.newscatcher.api_key');
    $apiUrl = 'https://api.newscatcherapi.com/v2/search';

    $queryParams = [
        'countries' => 'US',
        'topic' => 'tech',
        'q' => $request->get('q', ''),
        'from' => $request->get('from', ''),
        'to' => $request->get('to', ''),
    ];

    \Log::info('API Query Params:', $queryParams);

    $response = Http::withHeaders([
        'x-api-key' => $apiKey,
    ])->get($apiUrl, $queryParams);

    \Log::info('API Response:', $response->json());

    if ($response->successful()) {
        $newsArticles = $response->json()['articles'] ?? [];
    } else {
        $newsArticles = [];
    }

    return view('articles.api_news', [
        'newsArticles' => $newsArticles,
        'searchQuery' => $request->get('q', ''),
        'fromDate' => $request->get('from', ''),
        'toDate' => $request->get('to', ''),
    ]);
}


}
