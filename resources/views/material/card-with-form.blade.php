@card([
    'title' => $title ?? null,
    'subtitle' => $subtitle ?? null,
    'actions' => $actions ?? null,
    'modifiers' => ['card--with-form']
])
    {{ $slot }}
@endcard