{{-- Layout --}}
@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.groups')
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
                'title' => __('resources.groups'),
                'content' => __('messages.groups.subheading'),
            ]) @endheading        
        @endcell
        
        {{-- Paginável --}}
        @cell
            @paginableGroups([
                'groups' => $groups,
            ]) @endpaginableGroups 
        @endcell
        
        {{-- Novo --}}
        @can('create', \Modules\Group\Entities\Group::class)
            @fabFixed([
                'fab' => [
                    'isLink' => true,
                    'icon' => __('icons.add'),
                    'classes' => ['mdc-fab--extended'],
                    'label' => __('actions.new'),
                    'attrs' => [
                        'href' => url('groups/create'),
                        'title' => __('messages.groups.forms.create_title'),
                        'alt' => __('messages.groups.forms.create_title')
                    ],
                ]
            ]) @endfabFixed
        @endcan
    @endgridWithInner
@endsection
