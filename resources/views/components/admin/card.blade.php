@props(['title' => null, 'icon' => null, 'action' => null])

<div class="card">
    @if ($title || $action)
        <div class="card-header">
            @if ($title)
                <h4>
                    @if ($icon)
                        <i class="fas fa-{{ $icon }}"></i>
                    @endif
                    {{ $title }}
                </h4>
            @endif
            @if ($action)
                <div class="card-header-action">
                    {!! $action !!}
                </div>
            @endif
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
