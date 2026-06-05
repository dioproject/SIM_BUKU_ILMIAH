@extends('layouts.app-author')

@section('title', $bab->nama . ' - Detail')

@push('style')
    <style>
        .file-card {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        .file-card:hover {
            transform: translateX(5px);
        }
        .file-card.file-bab { border-color: #007bff; }
        .file-card.file-review { border-color: #28a745; }
        .file-card.file-notes { border-color: #ffc107; }
        
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            border-color: #007bff;
            background: #f8f9fa;
        }
        .upload-area.dragover {
            border-color: #007bff;
            background: #e9ecef;
        }
    </style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-book-open"></i> {{ $bab->nama }}</h1>
        </div>
        <div class="section-body">
            <x-flash-message />
            
            <div class="row">
                <div class="col-lg-8">
                    <x-admin.card title="Informasi Bab" icon="info-circle">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Buku:</strong></p>
                                <p>{{ $bab->buku->judul }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status:</strong></p>
                                <x-status-badge :status="$bab->status" />
                            </div>
                        </div>
                        
                        @if ($bab->author)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Author:</strong></p>
                                    <p><i class="fas fa-user"></i> {{ $bab->author->username }}</p>
                                </div>
                                @if ($bab->reviewer)
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Reviewer:</strong></p>
                                        <p><i class="fas fa-user-check"></i> {{ $bab->reviewer->username }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </x-admin.card>
                    
                    <!-- File Naskah -->
                    @if ($bab->file_bab)
                        <x-admin.card title="File Naskah" icon="file-alt" class="file-card file-bab">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $bab->file_bab }}</h5>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> Diunggah: 
                                        {{ \Carbon\Carbon::parse($bab->uploaded_at)->translatedFormat('l, d F Y H:i') }}
                                    </small>
                                </div>
                                <a class="btn btn-primary" 
                                    href="{{ Storage::url('upload/books/' . $bab->file_bab) }}"
                                    download="{{ $bab->file_bab }}">
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                            </div>
                        </x-admin.card>
                    @endif
                    
                    <!-- File Review -->
                    @if ($bab->file_revieu)
                        <x-admin.card title="File Review" icon="file-alt" class="file-card file-review">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $bab->file_revieu }}</h5>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> Direview: 
                                        {{ \Carbon\Carbon::parse($bab->updated_at)->translatedFormat('l, d F Y H:i') }}
                                    </small>
                                </div>
                                <a class="btn btn-success" 
                                    href="{{ Storage::url('upload/books/' . $bab->file_revieu) }}"
                                    download="{{ $bab->file_revieu }}">
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                            </div>
                        </x-admin.card>
                    @endif
                    
                    <!-- Catatan Reviewer -->
                    @if ($bab->catatan)
                        <x-admin.card title="Catatan Reviewer" icon="sticky-note" class="file-card file-notes">
                            <p class="mb-0">{{ $bab->catatan }}</p>
                        </x-admin.card>
                    @endif
                </div>
                
                <div class="col-lg-4">
                    <!-- Upload Form -->
                    @if ($bab->status_id === 4 && $bab->author_id == auth()->id())
                        <x-admin.card title="Unggah Naskah" icon="upload">
                            <form action="{{ route('author.upload.chapter', $bab->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="upload-area mb-3">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="mb-2">Pilih file naskah</p>
                                    <small class="text-muted">Format: .doc, .docx (Maks. 10MB)</small>
                                </div>
                                
                                <div class="form-group">
                                    <input type="file" name="file_bab" class="form-control-file" 
                                        accept=".doc,.docx" required id="fileInput">
                                </div>
                                
                                <div id="fileInfo" class="alert alert-info" style="display: none;">
                                    <i class="fas fa-file-word"></i> <span id="fileName"></span>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-upload"></i> Unggah Naskah
                                </button>
                            </form>
                        </x-admin.card>
                    @endif
                    
                    <!-- Info Status -->
                    <x-admin.card title="Informasi Status" icon="info-circle">
                        <div class="text-center">
                            @if ($bab->status_id == 4)
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle"></i>
                                    Bab ini sedang menunggu Anda untuk mengunggah naskah.
                                </div>
                            @elseif ($bab->status_id == 5)
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Bab ini perlu direvisi. Silakan periksa catatan reviewer.
                                </div>
                            @elseif ($bab->status_id == 6)
                                <div class="alert alert-primary mb-0">
                                    <i class="fas fa-search"></i>
                                    Naskah sedang dalam proses review oleh reviewer.
                                </div>
                            @elseif ($bab->status_id == 3)
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle"></i>
                                    Bab ini sudah disetujui.
                                </div>
                            @else
                                <div class="alert alert-secondary mb-0">
                                    <i class="fas fa-info-circle"></i>
                                    Status: {{ $bab->status->option }}
                                </div>
                            @endif
                        </div>
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#fileInput').on('change', function(e) {
                var fileName = e.target.files[0].name;
                var fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
                
                $('#fileName').text(fileName + ' (' + fileSize + ' MB)');
                $('#fileInfo').show();
            });
        });
    </script>
@endpush
