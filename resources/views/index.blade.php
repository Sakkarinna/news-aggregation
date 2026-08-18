@php
    $layout = auth()->check() && auth()->user()->role === 'admin'
        ? 'layouts.admin_dashboard_layout'
        : 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'Sakkarin News - Home')

@section('content')
<div class="container mx-auto mt-10 p-6">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-blue-800 mb-4">Welcome to Sakkarin News</h1>
        <p class="text-lg text-gray-700 max-w-2xl mx-auto">
            Your trusted source for reliable, up-to-date news articles on a wide range of topics. At Sakkarin News, we bring you stories that matter, written by dedicated contributors and journalists. Stay informed and never miss out on the latest happenings around the world.
        </p>
    </div>

    <div class="text-center">
        <a href="{{ route('articles.index') }}" class="inline-block px-8 py-4 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition ease-in-out duration-200">
            Get Started
        </a>
    </div>

    <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        <div class="p-6 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Breaking News</h2>
            <p class="text-gray-700">
                Stay updated with the latest breaking news from around the globe. Our dedicated team of journalists provides accurate and timely coverage to keep you informed.
            </p>
        </div>

        <div class="p-6 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">In-Depth Articles</h2>
            <p class="text-gray-700">
                Dive into our collection of in-depth articles that provide comprehensive insights and analysis on various topics. We bring you well-researched stories that give context to the news.
            </p>
        </div>

        <div class="p-6 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Community Voices</h2>
            <p class="text-gray-700">
                Read articles contributed by members of the community, sharing their perspectives and experiences on a range of issues. Get involved and make your voice heard.
            </p>
        </div>
    </div>
</div>
@endsection
