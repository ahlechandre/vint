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
                'title' => 'Tipo de membro',
                'subtitle' => 'Escolha o seu tipo de membro',
            ])
                @listTwoLineWithLink([
                    'items' => $memberTypes->map(function ($memberType) {
                        return [
                            'text' => $memberType->name,
                            'secondaryText' => $memberType->description,
                            'icon' => __("material_icons.{$memberType->slug}"),
                            'attrs' => [
                                'href' => request()->fullUrlWithQuery([
                                    'member-type' => $memberType->slug
                                ])
                            ],
                            'meta' => [
                                'icon' => __('material_icons.forward'),
                                'attrs' => [
                                    'href' => request()->fullUrlWithQuery([
                                        'member-type' => $memberType->slug
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