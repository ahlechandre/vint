{{-- Layout --}}
@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.publications')
])

{{-- Conteúdo --}}
@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        @cell
            {{-- Heading --}}
            @heading([
                'title' => __('resources.publications'),
                'content' => __('messages.publications.subheading'),
            ]) @endheading
        @endcell

        {{-- Paginável --}}
        @cell
            @paginablePublications([
                'publications' => $publications,
            ]) @endpaginablePublications        
        @endcell
        
        {{-- Novo --}}
        @can('create', \Modules\Product\Entities\Publication::class)
            @fabFixed([
                'fab' => [
                    'isLink' => true,
                    'icon' => __('icons.add'),
                    'classes' => ['mdc-fab--extended'],
                    'label' => __('actions.new'),
                    'attrs' => [
                        'href' => url('publications/create'),
                        'title' => __('messages.publications.forms.create_title'),
                    ],
                ]
            ]) @endfabFixed
        @endcan
    @endgridWithInner
@endsection
