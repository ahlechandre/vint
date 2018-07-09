<nav class="mdc-tab-bar mdc-tab-bar--icons-with-text">
    @foreach ($tabs as $tab)
        <a class="mdc-tab mdc-tab--with-icon-and-text{{ $tab['isActive'] ? ' mdc-tab--active' : '' }}" {{ setAttributes($tab['attrs'] ?? []) }}>
            <i class="material-icons mdc-tab__icon" aria-hidden="true">{{ $tab['icon'] }}</i>
            <span class="mdc-tab__icon-text">{{ $tab['text'] }}</span>
            <span class="mdc-tab__indicator"></span>
        </a>
    @endforeach
</nav>