@extends('layouts.default') 
@section('title', 'Novo membro')

@section('main')
    {{-- Surface --}}
    @component('components.ui.top-app-bar-surface', [
      'modifiers' => [
        'top-app-bar-surface--expanded',
        'top-app-bar-surface--min-height',
      ]
    ]) @endcomponent
    
    {{-- Content --}}
    @layoutGridWithInner([
      'modifiers' => ['layout-grid--with-form']
    ])
        @cell([
        'when' => ['default' => 12],
        ])
            @card([
                'title' => 'Papel',
                'subtitle' => "Indique o seu papel nos grupos"
            ])
                @listTwoLineWithLink([
                    'items' => $roles->map(function ($role) {
                        return [
                            'text' => $role->name,
                            'secondaryText' => $role->description,
                            'icon' => __("material_icons.{$role->slug}"),
                            'attrs' => [
                                'title' => $role->description,
                                'href' => request()->fullUrlWithQuery([
                                    'role' => $role->slug
                                ])
                            ],
                            'meta' => [
                                'icon' => __('material_icons.forward'),
                                'attrs' => [
                                    'href' => request()->fullUrlWithQuery([
                                        'role' => $role->slug
                                    ])
                                ],
                            ]
                        ];
                    })
                ]) @endlistTwoLineWithLink
            @endcard
        @endcell
    @endlayoutGridWithInner
  
@endsection