@extends('layouts.app-admin')

@section('title', $buku->judul . ' - Detail')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <style>
        .chapter-status-card {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        .chapter-status-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .chapter-status-card.status-draft { border-color: #6c757d; }
        .chapter-status-card.status-tersedia { border-color: #007bff; }
        .chapter-status-card.status-ditugaskan { border-color: #17a2b8; }
        .chapter-status-card.status-dikirim { border-color: #ffc107; }
        .chapter-status-card.status-review { border-color: #007bff; }
        .chapter-status-card.status-revisi { border-color: #dc3545; }
        .chapter-status-card.status-disetujui { border-color: #28a745; }
        
        .assign-btn {
            transition: all 0.2s ease;
        }
        .assign-btn:hover {
            transform: scale(1.05);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .modal-header .close {
            color: white;
            opacity: 0.8;
        }
        .modal-header .close:hover {
            opacity: 1;
        }
        
        .book-info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        .book-info-card h4 {
            margin-bottom: 0;
        }
        .book-info-card .book-stats {
            font-size: 2.5rem;
            font-weight: bold;
        }
    </style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-book"></i> {{ $buku->judul }}</h1>
        </div>
        
        @php
            $totalBab = (int) $buku->total_bab;
            $currentBabCount = $babs->count();
            $assignedCount = $babs->where('author_id', '!=', null)->count();
            $approvedCount = $babs->where('status_id', \App\Models\Status::DISETUJUI)->count();
        @endphp
        
        <div class="section-body">
            <x-flash-message />
            
            <!-- Book Info Card -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card book-info-card">
                        <div class="card-body">
                            <h4>Total Bab</h4>
                            <div class="book-stats">{{ $totalBab }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card book-info-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <div class="card-body">
                            <h4>Sudah Ditugaskan</h4>
                            <div class="book-stats">{{ $assignedCount }} / {{ $totalBab }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card book-info-card" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);">
                        <div class="card-body">
                            <h4>Sudah Disetujui</h4>
                            <div class="book-stats">{{ $approvedCount }} / {{ $totalBab }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Daftar Bab" icon="list">
                        @if ($currentBabCount < $totalBab)
                            <form action="{{ route('admin.store.chapter', $buku->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> 
                                    Silakan masukkan nama-nama bab yang tersisa ({{ $totalBab - $currentBabCount }} bab lagi).
                                </div>
                                @for ($i = $currentBabCount + 1; $i <= $totalBab; $i++)
                                    <x-admin.form-field label="Bab {{ $i }}" name="bab[]" :required="true">
                                        <input type="text" tabindex="{{ $i }}" class="form-control" 
                                            name="bab[]" value="{{ old('bab.' . ($i - 1)) }}" 
                                            placeholder="Masukkan nama bab {{ $i }}">
                                    </x-admin.form-field>
                                @endfor
                                
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                    <div class="col-sm-12 col-md-10">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="far fa-save"></i> Simpan Bab
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif

                        @if ($currentBabCount == $totalBab)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama Bab</th>
                                            <th>Penulis</th>
                                            <th>Reviewer</th>
                                            <th width="150">Status</th>
                                            <th width="120">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($babs as $key => $bab)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <strong>{{ $bab->nama }}</strong>
                                                </td>
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
                                                    @if($bab->reviewer)
                                                        <span class="badge badge-light">
                                                            <i class="fas fa-user-check"></i> {{ $bab->reviewer->username }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <x-status-badge :status="$bab->status" />
                                                </td>
                                                <td>
                                                    <button class="btn btn-info btn-sm assign-btn" 
                                                        data-toggle="tooltip" title="Penugasan"
                                                        onclick="openAssignModal({{ $bab->id }}, '{{ $bab->nama }}', {{ $bab->author_id ?? 'null' }}, {{ $bab->reviewer_id ?? 'null' }})">
                                                        <i class="fas fa-user-edit"></i>
                                                    </button>
                                                    <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Detail"
                                                        href="{{ route('admin.show.chapter', $bab->id) }}">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Progress Info -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="progress" style="height: 25px;">
                                        @php
                                            $progressPercent = ($approvedCount / $totalBab) * 100;
                                        @endphp
                                        <div class="progress-bar bg-success" role="progressbar" 
                                            style="width: {{ $progressPercent }}%" 
                                            aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100">
                                            {{ round($progressPercent) }}% Selesai
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    @if($approvedCount == $totalBab)
                                        <a href="{{ route('admin.merge.book', $buku->id) }}" class="btn btn-primary">
                                            <i class="fas fa-object-group"></i> Gabungkan Bab
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-info-circle"></i> 
                                            Semua bab harus disetujui untuk digabungkan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
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
                            <i class="fas fa-user-check"></i> Reviewer
                        </label>
                        <select name="reviewer_id" id="assignReviewer" class="form-control select2" style="width: 100%;">
                            <option value="">-- Pilih Reviewer (Opsional) --</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}">{{ $reviewer->username }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Reviewer yang akan menilai bab ini</small>
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
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                language: 'id'
            });
        });

        function openAssignModal(chapterId, chapterName, currentAuthorId, currentReviewerId) {
            // Set chapter info
            $('#assignChapterId').val(chapterId);
            $('#assignChapterName').text(chapterName);
            
            // Set current values
            $('#assignAuthor').val(currentAuthorId).trigger('change');
            $('#assignReviewer').val(currentReviewerId).trigger('change');
            
            // Set form action URL
            $('#assignForm').attr('action', '/admin/chapter/' + chapterId + '/assign');
            
            // Show modal
            $('#assignModal').modal('show');
        }

        // Handle form submission via AJAX
        $('#assignForm').on('submit', function(e) {
            e.preventDefault();
            
            var $btn = $('#assignSubmitBtn');
            var originalText = $btn.html();
            
            // Show loading state
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#assignModal').modal('hide');
                    
                    // Show success message
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
