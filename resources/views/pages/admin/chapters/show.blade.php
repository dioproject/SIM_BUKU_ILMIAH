@extends('layouts.app-admin')

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

        .assign-btn {
            transition: all 0.2s ease;
        }
        .assign-btn:hover {
            transform: scale(1.05);
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

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Penulis:</strong></p>
                                <p><i class="fas fa-user"></i> {{ $bab->author->username ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Pereview:</strong></p>
                                <p><i class="fas fa-user-check"></i> {{ $bab->reviewer->username ?? '-' }}</p>
                            </div>
                        </div>

                        @if ($bab->deadline)
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Tenggat:</strong></p>
                                    <p><i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($bab->deadline)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </x-admin.card>

                    <!-- File Naskah Author -->
                    @if ($bab->file_bab)
                        <x-admin.card title="File Naskah" icon="file-alt" class="file-card file-bab">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $bab->file_bab }}</h5>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> Diunggah:
                                        {{ $bab->uploaded_at ? \Carbon\Carbon::parse($bab->uploaded_at)->translatedFormat('l, d F Y H:i') : '-' }}
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
                                        {{ $bab->updated_at ? \Carbon\Carbon::parse($bab->updated_at)->translatedFormat('l, d F Y H:i') : '-' }}
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

                    <!-- Catatan -->
                    @if ($bab->catatan)
                        <x-admin.card title="Catatan Review" icon="sticky-note" class="file-card file-notes">
                            <p class="mb-0">{{ $bab->catatan }}</p>
                        </x-admin.card>
                    @endif
                </div>

                <div class="col-lg-4">
                    <!-- Aksi Admin -->
                    <x-admin.card title="Aksi Admin" icon="tools">
                        <div class="d-grid gap-2">
                            @if ($bab->status_id != \App\Models\Status::DISETUJUI)
                                <button class="btn btn-info btn-block assign-btn mb-2"
                                    onclick="openAssignModal({{ $bab->id }}, '{{ $bab->nama }}', {{ $bab->author_id ?? 'null' }}, {{ $bab->reviewer_id ?? 'null' }})">
                                    <i class="fas fa-user-edit"></i> Atur Penugasan
                                </button>
                            @endif

                            @if ($bab->status_id == \App\Models\Status::DALAM_REVIEW || $bab->status_id == \App\Models\Status::DIREVISI)
                                <form action="{{ route('admin.approve.chapter', $bab->id) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check-circle"></i> Setujui Bab
                                    </button>
                                </form>
                            @endif
                        </div>
                    </x-admin.card>

                    <!-- Info Status -->
                    <x-admin.card title="Informasi Status" icon="info-circle">
                        <div class="text-center">
                            @if ($bab->status_id == \App\Models\Status::DITUGASKAN)
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle"></i>
                                    Bab menunggu penulis mengunggah naskah.
                                </div>
                            @elseif ($bab->status_id == \App\Models\Status::REVISI)
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Bab dalam tahap revisi oleh penulis.
                                </div>
                            @elseif ($bab->status_id == \App\Models\Status::DALAM_REVIEW)
                                <div class="alert alert-primary mb-0">
                                    <i class="fas fa-search"></i>
                                    Naskah sedang direview oleh reviewer.
                                </div>
                            @elseif ($bab->status_id == \App\Models\Status::DISETUJUI)
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle"></i>
                                    Bab ini sudah disetujui.
                                </div>
                            @elseif ($bab->status_id == \App\Models\Status::DIKIRIM_AUTHOR)
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Naskah sudah dikirim oleh penulis.
                                </div>
                            @elseif ($bab->status_id == \App\Models\Status::DIREVISI)
                                <div class="alert alert-secondary mb-0">
                                    <i class="fas fa-redo"></i>
                                    Revisi sudah diunggah oleh penulis.
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

<!-- Assignment Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">
                    <i class="fas fa-user-edit"></i> Penugasan Bab
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assignForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-book"></i> Informasi Bab
                            </h6>
                            <p class="card-text mt-2 mb-0">
                                <strong id="assignChapterName"></strong>
                            </p>
                            <input type="hidden" name="chapter_id" id="assignChapterId">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="assignAuthor">
                            <i class="fas fa-user"></i> Penulis <span class="text-danger">*</span>
                        </label>
                        <select name="author_id" id="assignAuthor" class="form-control select2" required style="width: 100%;">
                            <option value="">-- Pilih Penulis --</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->username }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Penulis yang akan menulis bab ini</small>
                    </div>

                    <div class="form-group">
                        <label for="assignReviewer">
                            <i class="fas fa-user-check"></i> Pereview
                        </label>
                        <select name="reviewer_id" id="assignReviewer" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Pereview (Opsional) --</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}">{{ $reviewer->username }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pereview yang akan menilai bab ini</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="assignSubmitBtn">
                        <i class="far fa-save"></i> Simpan Penugasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                language: 'id'
            });
        });

        function openAssignModal(chapterId, chapterName, currentAuthorId, currentReviewerId) {
            $('#assignChapterId').val(chapterId);
            $('#assignChapterName').text(chapterName);
            $('#assignAuthor').val(currentAuthorId).trigger('change');
            $('#assignReviewer').val(currentReviewerId).trigger('change');
            $('#assignForm').attr('action', '/admin/chapter/' + chapterId + '/assign');
            $('#assignModal').modal('show');
        }

        $('#assignForm').on('submit', function(e) {
            e.preventDefault();

            var $btn = $('#assignSubmitBtn');
            var originalText = $btn.html();

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#assignModal').modal('hide');
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Penugasan bab berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    var message = 'Terjadi kesalahan saat menyimpan penugasan.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: message
                        });
                    } else {
                        alert(message);
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });
    </script>
@endpush