@php
    $layout = auth()->check() && auth()->user()->role === 'admin'
        ? 'layouts.admin_dashboard_layout'
        : 'layouts.layout';
@endphp

@extends($layout)

@section('title', 'API News')

@section('content')
    <livewire:api-news-feed />
@endsection
