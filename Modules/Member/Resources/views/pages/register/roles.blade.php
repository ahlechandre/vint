@extends('layouts.search', [
    'title' => __('headlines.register')
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @heading([
                'pretitle' => __('resources.members'),
                'title' => __('headlines.register'),
            ]) @endheading
        @endcell

        {{-- Escolha --}}
        @cell
            @list([
                'isNavigation' => true,
                'twoLine' => true,
                'items' => $roles->map(function ($role) {
                    return [
                        'text' => [
                            'primary' => $role->name,
                            'secondary' => $role->description,
                        ],
                        'attrs' => [
                            'href' => request()->fullUrlWithQuery([
                                'role' => $role->slug
                            ]),
                        ],
                        'meta' => [
                            'icon' => __('icons.forward')
                        ]
                    ];
                })
            ]) @endlist
        @endcell
    @endgridWithInner
@endsection
