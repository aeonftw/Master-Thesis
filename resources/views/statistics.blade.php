@extends('layouts.app')

@section('content')
    <!-- Your existing HTML code for the statistics page -->
    <h1>Statistics</h1>
    <p>Total Posts: {{ $postCount }}</p>
    <p>Total Categories: {{ $categoryCount }}</p>
    <p>Total Comments: {{ $commentCount }}</p>
    <p>Online Users: {{ $onlineUsers }}</p>
    <p>Total Users: {{ $totalUsers }}</p>

    <!-- Add a container for the chart -->
    <div id="chartContainer" style="width: 100%; height: 700px;">
        <canvas id="chart"></canvas>
    </div>
@endsection

@section('scripts')
    <!-- Add the Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Add the chart initialization code within a <script> tag -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('chart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total Posts', 'Total Categories', 'Total Comments', 'Online Users', 'Total Users'],
                    datasets: [{
                        label: 'Statistics',
                        data: [{{ $postCount }}, {{ $categoryCount }}, {{ $commentCount }}, {{ $onlineUsers }}, {{ $totalUsers }}],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
