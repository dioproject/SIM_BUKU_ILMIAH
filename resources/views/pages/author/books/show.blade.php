@extends('layouts.app-author')

@section('title', $buku->judul . ' - Detail')

@push('style')
    <style>
        .upload-form {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }
        .upload-btn {
            transition: all 0.2s ease;
        }
        .upload-btn:hover {
            transform: scale(1.05);
        }
    </style>
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
                                        <th>Penulis</th>
                                        <th width="150">Status</th>
                                        <th width="100">Aksi</th>
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
                                                    href="{{ route('author.show.chapter', $bab->id) }}">
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
