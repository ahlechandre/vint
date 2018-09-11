<header class="top-app-bar mdc-top-app-bar{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCTopAppBar">
    @foreach($rows as $row)
        <div class="top-app-bar__row mdc-top-app-bar__row{{ set_classes($row['classes'] ?? []) }}"{{ set_attrs($row['attrs'] ?? []) }}>
            @foreach($row['sections'] as $section)
                <section class="top-app-bar__section mdc-top-app-bar__section{{ set_classes($section['classes'] ?? []) }}"{{ set_attrs($section['attrs'] ?? []) }}>
                    @if ($section['menu'] ?? false)
                        <a class="material-icons mdc-top-app-bar__navigation-icon{{ set_classes($section['menu']['classes'] ?? []) }}"{{ set_attrs($section['menu']['attrs'] ?? []) }}>{{ $section['menu']['icon'] }}</a>
                    @endif

                    @if ($section['title'] ?? false)
                        <a class="mdc-top-app-bar__title{{ set_classes($section['title']['classes'] ?? []) }}"{{ set_attrs($section['title']['attrs'] ?? []) }}>{{ $section['title']['text'] }}</a>
                    @endif

                    @if ($section['actions'] ?? false)
                        @foreach($section['actions'] as $action)
                            <a class="material-icons mdc-top-app-bar__action-item{{ set_classes($action['classes'] ?? []) }}"{{ set_attrs($action['attrs'] ?? []) }}>{{ $action['icon'] }}</a>
                        @endforeach
                    @endif

                    @if ($section['component'] ?? false)
                        @component($section['component']['view'], $section['component']['props'] ?? []) @endcomponent
                    @endif
                </section>
            @endforeach
        </div>
    @endforeach
</header>