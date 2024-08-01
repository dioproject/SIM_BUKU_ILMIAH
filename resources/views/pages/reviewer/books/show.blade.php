@extends('layouts.app-reviewer')

@section('title', $buku->judul . ' Detail')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $buku->judul }} Detail</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Bab</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($babs as $key => $bab)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $bab->nama }}</td>
                                                    <td>{{ $bab->author->username ?? '' }}</td>
                                                    <td>{{ $bab->status->option }}</td>
                                                    <td>
                                                        <a class="btn btn-success btn-action" data-toggle="tooltip"
                                                            title="Detail"
                                                            href="{{ route('reviewer.show.chapter', $bab->id) }}"><i
                                                                class="fas fa-list"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
