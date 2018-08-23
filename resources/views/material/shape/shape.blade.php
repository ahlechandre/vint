<div class="mdc-shape-container{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    {{ $slot }}

    @foreach($corners as $corner)
    <div class="mdc-shape-container__corner mdc-shape-container__corner--{{ $corner }}"></div>    
    @endforeach
</div>