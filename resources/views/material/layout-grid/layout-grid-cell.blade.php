<div class="layout-grid__cell mdc-layout-grid__cell{{ isset($when) ? set_mdc_cells($when) : ' mdc-layout-grid__cell--span-12' }}{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    {{ $slot }}
</div>