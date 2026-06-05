@props(['status'])

@php
    $statusId = $status->id ?? null;
    $statusLabel = $status->option ?? 'Belum Ada Status';

    $badgeClass = match($statusId) {
        \App\Models\Status::DRAFT => 'badge-secondary',
        \App\Models\Status::TERSEDIA => 'badge-primary',
        \App\Models\Status::DISETUJUI => 'badge-success',
        \App\Models\Status::DITUGASKAN => 'badge-info',
        \App\Models\Status::REVISI => 'badge-danger',
        \App\Models\Status::DALAM_REVIEW => 'badge-primary',
        \App\Models\Status::DIKIRIM_AUTHOR => 'badge-warning',
        \App\Models\Status::DIREVISI => 'badge-warning',
        \App\Models\Status::FINALISASI => 'badge-dark',
        \App\Models\Status::TERBIT => 'badge-success',
        default => 'badge-secondary'
    };

    $icon = match($statusId) {
        \App\Models\Status::DRAFT => 'file',
        \App\Models\Status::TERSEDIA => 'check-circle',
        \App\Models\Status::DISETUJUI => 'check-double',
        \App\Models\Status::DITUGASKAN => 'user-check',
        \App\Models\Status::REVISI => 'exclamation-triangle',
        \App\Models\Status::DALAM_REVIEW => 'search',
        \App\Models\Status::DIKIRIM_AUTHOR => 'upload',
        \App\Models\Status::DIREVISI => 'redo',
        \App\Models\Status::FINALISASI => 'book',
        \App\Models\Status::TERBIT => 'globe',
        default => 'circle'
    };
@endphp

<span class="badge {{ $badgeClass }}">
    <i class="fas fa-{{ $icon }}"></i>
    {{ $statusLabel }}
</span>
