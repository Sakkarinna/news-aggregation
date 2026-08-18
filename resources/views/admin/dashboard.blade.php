@extends('layouts.admin_dashboard_layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Users Graph -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Total Users</h2>
                <canvas id="totalUsersChart"></canvas>
            </div>

            <!-- Total Contents Graph -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Total Contents</h2>
                <canvas id="totalContentsChart"></canvas>
            </div>

            <!-- Total Categories Graph -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Total Categories</h2>
                <canvas id="totalCategoriesChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamic Data
            const totalUsersData = {{ $totalUsers }};
            const totalContentsData = {
                articles: {{ $totalContents['articles'] }},
                comments: {{ $totalContents['comments'] }}
            };
            const totalCategoriesData = {{ $totalCategories }};

            // Total Users Chart
            const totalUsersCtx = document.getElementById('totalUsersChart').getContext('2d');
            new Chart(totalUsersCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Users'],
                    datasets: [{
                        data: [totalUsersData],
                        backgroundColor: ['#3b82f6'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });

            // Total Contents Chart
            const totalContentsCtx = document.getElementById('totalContentsChart').getContext('2d');
            new Chart(totalContentsCtx, {
                type: 'bar',
                data: {
                    labels: ['Articles', 'Comments'],
                    datasets: [{
                        data: [totalContentsData.articles, totalContentsData.comments],
                        backgroundColor: ['#10b981', '#f59e0b'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Total Categories Chart
            const totalCategoriesCtx = document.getElementById('totalCategoriesChart').getContext('2d');
            new Chart(totalCategoriesCtx, {
                type: 'pie',
                data: {
                    labels: ['Categories'],
                    datasets: [{
                        data: [totalCategoriesData],
                        backgroundColor: ['#ef4444'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endsection
