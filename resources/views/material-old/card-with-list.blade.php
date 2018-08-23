@component('material.card', [
    'title' => $title ?? null,
    'subtitle' => $subtitle ?? null,
    'actions' => $actions ?? null,
    'modifiers' => ['card--with-list']
])
    @component('material.list-two-line', $list) @endcomponent
@endcomponent