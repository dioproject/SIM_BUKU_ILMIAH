@extends('layouts.app-author')

@section('title', $bab->nama . ' Detail')

@push('style')
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $bab->nama }} Detail</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $bab->nama }}</strong>
                                    @if ($bab->file_bab)
                                        <small class="text-danger">
                                            {{ \Carbon\Carbon::parse($bab->deadline)->translatedFormat('l, d F Y') }}
                                        </small>
                                    @endif
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
                                                    <small>Author: {{ $bab->author->username }}</small>
                                                    <small>Uploaded:
                                                        {{ \Carbon\Carbon::parse($bab->uploaded_at)->translatedFormat('l, d F Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($bab->file_reviu)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <i class="fas fa-file"></i>
                                                    <strong>{{ $bab->file_reviu }}</strong>
                                                </div>
                                                <div class="d-flex justify-content-between col-md-12 py-1">
                                                    <small>Reviewer: {{ $bab->reviewer->username }}</small>
                                                    @if ($bab->status->option != 'Pending')
                                                        <small>Reviewed:
                                                            {{ \Carbon\Carbon::parse($bab->updated_at)->translatedFormat('l, d F Y') }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($bab->catatan)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <strong>Notes:</strong>
                                                    <small>{{ $bab->catatan }}</small>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($bab->status_id === 4)
                                        <li class="list-group-item">
                                            <form action="{{ route('author.upload.chapter', $bab->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="file" name="file_bab" class="form-control-file"
                                                            accept=".doc,.docx" required>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-upload"></i> Unggah
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                    @endif
                                    @if ($bab->status_id === 2)
                                        <li class="list-group-item">
                                            <form action="{{ route('author.claimed.chapter', $bab->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="file" name="file_bab" class="form-control-file"
                                                            accept=".jpg,.jpeg,.png" required>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-upload"></i> Klaim
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
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
