<aside
    {{ setAttributes($attrs) }}
    class="mdc-dialog"
    role="alertdialog"
    aria-labelledby="{{ $attrs['id'] }}-label"
    aria-describedby="{{ $attrs['id'] }}-description"
    data-dialog-activation="{{ $activation }}">
    <div class="mdc-dialog__surface">
        <header class="mdc-dialog__header">
            <h2 id="{{ $attrs['id'] }}-label" class="mdc-dialog__header__title">
                {{ $title }}
            </h2>
        </header>
    <section id="{{ $attrs['id'] }}-description"
        class="mdc-dialog__body{{ isset($isScrollable) && $isScrollable ? ' mdc-dialog__body--scrollable' : '' }}">
            {{ $slot }}
        </section>
        <footer class="mdc-dialog__footer">
            @if ($cancel ?? false)
                @component('material.button', array_merge($cancel, [
                    'modifiers' => [
                        'mdc-dialog__footer__button',
                        'mdc-dialog__footer__button--cancel'
                    ]
                ])) @endcomponent            
            @endif
            
            @component('material.button', array_merge($accept, [
                'modifiers' => [
                    'mdc-dialog__footer__button',
                    'mdc-dialog__footer__button--accept'
                ]
            ])) @endcomponent
        </footer>
    </div>
    <div class="mdc-dialog__backdrop"></div>
</aside>
