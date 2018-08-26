<div class="card__header{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    @if ($title ?? false)
        <h2 class="card__header-title">{{ $title }}</h2>
    @endif

    @if ($subtitle ?? false)
        <p class="card__header-subtitle">{{ $subtitle }}</p>
    @endif

    {{ $slot }}
</div>