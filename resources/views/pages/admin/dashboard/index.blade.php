@extends('layouts.app-admin')

@section('title', 'Dasbor')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-tachometer-alt"></i> Dasbor</h1>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-solid fa-feather"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Penulis</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalAuthors ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-regular fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Reviewer</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalReviewers ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-solid fa-user-group"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pengguna</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-solid fa-book"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Buku</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalBooks ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-secondary">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Bab</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalChapters ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Perlu Direview</h4>
                            </div>
                            <div class="card-body">
                                {{ $chaptersNeedingReview ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-dark">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Bab Disetujui</h4>
                            </div>
                            <div class="card-body">
                                {{ $approvedChapters ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-chart-bar"></i> Status Bab</h4>
                        </div>
                        <div class="card-body">
                            @forelse($chaptersByStatus ?? [] as $item)
                                <span class="badge badge-primary m-1 p-2">
                                    {{ $item->status->option ?? 'N/A' }}: <strong>{{ $item->count }}</strong>
                                </span>
                            @empty
                                <span class="text-muted">Belum ada bab.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="182"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Aktivitas Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($recentActivities as $activity)
                                    <li class="media">
                                        <img class="rounded-circle mr-3" width="50" src="{{ asset('img/avatar/avatar-1.png') }}" alt="avatar">
                                        <div class="media-body">
                                            <div class="float-right text-primary">{{ $activity->created_at->diffForHumans() }}</div>
                                            <div class="media-title">{{ $activity->author->username ?? '' }}</div>
                                            <span class="text-small text-muted">
                                                Bab yang dikirimkan : {{ $activity->nama }}
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
                    label: 'Total Bab Dibuat per Hari',
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
