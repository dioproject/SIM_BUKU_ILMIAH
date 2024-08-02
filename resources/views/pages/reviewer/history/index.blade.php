@extends('layouts.app-reviewer')
@section('title', 'History')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>History</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>History</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $key => $his)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $his->detail }}</td>
                                            <td>{{ $his->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                @if ($history->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $history->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                @foreach ($history->getUrlRange(1, $history->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $history->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($history->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $history->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
