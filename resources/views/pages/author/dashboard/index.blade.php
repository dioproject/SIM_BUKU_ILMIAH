@extends('layouts.app-author')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    @php
        use App\Models\Book;

        $books = Book::all()->count();
    @endphp
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg--12 col-md--12 col-sm--12 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-solid fa-book"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Books</h4>
                            </div>
                            <div class="card-body">
                                {{ $books }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="182"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Activities</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($recentActivities as $activity)
                                    <li class="media">
                                        <img class="rounded-circle mr-3" width="50" src="{{ asset('img/avatar/avatar-1.png') }}" alt="avatar">
                                        <div class="media-body">
                                            <div class="float-right text-primary">{{ $activity->created_at->diffForHumans() }}</div>
                                            <div class="media-title">{{ $activity->author->name ?? 'Unknown Author' }}</div>
                                            <span class="text-small text-muted">
                                                Submitted chapter: {{ $activity->title }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var statistics = @json($statistics);

        var labels = statistics.map(item => item.date);
        var data = statistics.map(item => item.count);

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Chapters Approved per Day',
                    data: data,
                    borderWidth: 2,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 3
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endpush
