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

            @php
                $chapterSearchAction = '
                    <form action="' . route('author.show.book', $buku->id) . '" method="GET" class="form-inline justify-content-end">
                        <div class="input-group">
                            <input type="text" name="chapter_search" class="form-control" placeholder="Cari bab..." value="' . e($chapterSearch ?? '') . '">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>';
            @endphp
            
            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Daftar Bab" icon="list" :action="$chapterSearchAction">
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
                                    @forelse ($babs as $key => $bab)
                                        <tr>
                                            <td>{{ $babs->firstItem() + $key }}</td>
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
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada bab yang cocok.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <x-admin.pagination :paginator="$babs" />
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush
