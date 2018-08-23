<nav class="mdc-tab-bar">
    @foreach ($tabs as $tab)
        <a class="mdc-tab mdc-ripple-surface{{ $tab['isActive'] ? ' mdc-tab--active' : '' }}" {{ setAttributes($tab['attrs'] ?? []) }}>
            {{ $tab['text'] }}
            <span class="mdc-tab__indicator"></span>
        </a>
    @endforeach
</nav>