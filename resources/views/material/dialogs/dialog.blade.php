<aside class="dialog mdc-dialog{{ set_classes($classes ?? []) }}"
  role="alertdialog"
  aria-labelledby="{{ $attrs['id'] ?? null }}-label"
  aria-describedby="{{ $attrs['id'] ?? null }}-description"{{ set_attrs($attrs ?? []) }}>
  <div class="mdc-dialog__surface">
    @if ($title ?? false)
        <header class="mdc-dialog__header">
            <h2 id="{{ $attrs['id'] ?? null }}-label" class="mdc-dialog__header__title">
                {{ $title }}
            </h2>
        </header> 
    @endif

    <section id="{{ $attrs['id'] ?? null }}-description" class="mdc-dialog__body{{ isset($scrollable) && $scrollable ? ' mdc-dialog__body--scrollable' : '' }}">
        @if ($component ?? false)
            @component($component['view'], $component['props'] ?? []) @endcomponent
        @endif
        @if ($text ?? false)
            <p>
                {!! nl2br($text) !!}
            </p>
        @endif
        {{ $slot }}
    </section>
    <footer class="mdc-dialog__footer">
        @if ($footer['buttonCancel'] ?? false)
            @button(component_with_classes($footer['buttonCancel'], [
                'mdc-dialog__footer__button',
                'mdc-dialog__footer__button--cancel'                
            ])) @endbutton
        @endif

        @button(component_with_classes($footer['buttonAccept'], [
            'mdc-dialog__footer__button',
            'mdc-dialog__footer__button--accept'
        ])) @endbutton
    </footer>
  </div>
  <div class="mdc-dialog__backdrop"></div>
</aside>