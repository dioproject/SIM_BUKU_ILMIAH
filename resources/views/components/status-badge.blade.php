@props(['status'])

@php
    $badgeClass = match($status->id) {
        1 => 'badge-secondary',
        2 => 'badge-primary',
        3 => 'badge-success',
        4 => 'badge-info',
        5 => 'badge-danger',
        6 => 'badge-primary',
        7 => 'badge-warning',
        8 => 'badge-warning',
        9 => 'badge-dark',
        10 => 'badge-success',
        default => 'badge-secondary'
    };

    $icon = match($status->id) {
        1 => 'file',
        2 => 'check-circle',
        3 => 'check-double',
        4 => 'user-check',
        5 => 'exclamation-triangle',
        6 => 'search',
        7 => 'upload',
        8 => 'redo',
        9 => 'book',
        10 => 'globe',
        default => 'circle'
    };
@endphp

<span class="badge {{ $badgeClass }}">
    <i class="fas fa-{{ $icon }}"></i>
    {{ $status->option }}
</span>
