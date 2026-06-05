@extends('layouts.app-admin')

@section('title', 'Detail ' . $bab->nama)

@push('style')
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-file-alt"></i> Detail {{ $bab->nama }}</h1>
        </div>
        <div class="section-body">
            <x-flash-message />
            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Informasi Bab" icon="info-circle">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">{{ $bab->nama }}</h5>
                            <div>
                                <x-status-badge :status="$bab->status" />
                                @if ($bab->file_bab)
                                    <small class="text-danger ml-2">
                                        {{ \Carbon\Carbon::parse($bab->deadline)->translatedFormat('l, d F Y') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        <ul class="list-group py-2">
                            @if ($bab->file_bab)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <i class="fas fa-file"></i>
                                            <strong>{{ $bab->file_bab }}</strong>
                                        </div>
                                        <div class="col-md-1 text-right">
                                            <a class="btn btn-secondary"
                                               href="{{ Storage::url('upload/books/' . $bab->file_bab) }}"
                                               download="{{ $bab->file_bab }}">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex justify-content-between col-md-12 py-1">
                                            <small><i class="fas fa-user"></i> Penulis: {{ $bab->author->username ?? '-' }}</small>
                                            <small><i class="fas fa-clock"></i> Diunggah: 
                                                {{ $bab->uploaded_at ? \Carbon\Carbon::parse($bab->uploaded_at)->translatedFormat('l, d F Y') : '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if ($bab->file_revieu)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <i class="fas fa-file"></i>
                                            <strong>{{ $bab->file_revieu }}</strong>
                                        </div>
                                        <div class="col-md-1 text-right">
                                            <a class="btn btn-secondary"
                                               href="{{ Storage::url('upload/books/' . $bab->file_revieu) }}"
                                               download="{{ $bab->file_revieu }}">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                        <div class="d-flex justify-content-between col-md-12 py-1">
                                            <small><i class="fas fa-user-check"></i> Pereview: {{ $bab->reviewer->username ?? '-' }}</small>
                                            <small><i class="fas fa-clock"></i> Direview: 
                                                {{ $bab->updated_at ? \Carbon\Carbon::parse($bab->updated_at)->translatedFormat('l, d F Y') : '-' }}
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @if ($bab->catatan)
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong><i class="fas fa-sticky-note"></i> Catatan:</strong>
                                            <br>
                                            <p class="mt-2 mb-0">{{ $bab->catatan }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush
