@extends('layouts.app-reviewer')

@section('title', $buku->judul . ' - Detail')

@push('style')
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-book"></i> {{ $buku->judul }}</h1>
        </div>
        <div class="section-body">
            <x-flash-message />
            
            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Daftar Bab" icon="list">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th>Nama Bab</th>
                                        <th>Author</th>
                                        <th width="150">Status</th>
                                        <th width="80">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($babs as $key => $bab)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><strong>{{ $bab->nama }}</strong></td>
                                            <td>
                                                @if($bab->author)
                                                    <span class="badge badge-light">
                                                        <i class="fas fa-user"></i> {{ $bab->author->username }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <x-status-badge :status="$bab->status" />
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Detail"
                                                    href="{{ route('reviewer.show.chapter', $bab->id) }}">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush
