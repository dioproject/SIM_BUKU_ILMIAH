@extends('layouts.app-author')

@section('title', 'Histori')

@push('style')
    <style>
        .action-badge {
            font-size: 0.85em;
            padding: 0.4em 0.6em;
        }
    </style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-history"></i> Histori</h1>
        </div>
        <div class="section-body">
            <x-flash-message />

            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Histori Aktivitas" icon="clock">
                        @if($history->count() > 0)
                            <x-admin.table :headers="['No', 'Aksi', 'Detail', 'Tanggal']">
                                @foreach ($history as $key => $his)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($his->action)
                                                @php
                                                    $actionClass = match($his->action) {
                                                        'create_book', 'create_chapter' => 'badge-primary',
                                                        'assign' => 'badge-info',
                                                        'upload', 'upload_review' => 'badge-warning',
                                                        'approve' => 'badge-success',
                                                        'revisi' => 'badge-danger',
                                                        default => 'badge-secondary'
                                                    };

                                                    $actionLabel = match($his->action) {
                                                        'create_book' => 'Buat Buku',
                                                        'create_chapter' => 'Buat Bab',
                                                        'assign' => 'Penugasan',
                                                        'upload' => 'Unggah',
                                                        'upload_review' => 'Unggah Review',
                                                        'approve' => 'Setujui',
                                                        'revisi' => 'Revisi',
                                                        default => ucfirst(str_replace('_', ' ', $his->action))
                                                    };

                                                    $actionIcon = match($his->action) {
                                                        'create_book', 'create_chapter' => 'plus-circle',
                                                        'assign' => 'user-edit',
                                                        'upload', 'upload_review' => 'upload',
                                                        'approve' => 'check-circle',
                                                        'revisi' => 'exclamation-triangle',
                                                        default => 'info-circle'
                                                    };
                                                @endphp
                                                <span class="badge {{ $actionClass }} action-badge">
                                                    <i class="fas fa-{{ $actionIcon }}"></i>
                                                    {{ $actionLabel }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $his->detail }}</td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($his->created_at)->translatedFormat('l, d F Y H:i') }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-admin.table>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada histori</h5>
                                <p class="text-muted">Riwayat aktivitas Anda akan muncul di sini.</p>
                            </div>
                        @endif

                        <x-admin.pagination :paginator="$history" />
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush