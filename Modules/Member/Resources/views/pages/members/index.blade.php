{{-- Layout --}}
@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.members')
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
                'title' => __('resources.members'),
                'content' => __('messages.members.subheading'),
            ]) @endheading        
        @endcell
        
        @cell
            {{-- Paginável --}}
            @paginable([
                'paginator' => $members,
                'list' => [
                    'isNavigation' => true,
                    'twoLine' => true,
                    'items' => $members->map(function ($member) {
                        return [
                            'icon' => __('icons.member'),
                            'text' => [
                                'primary' => $member->user->name,
                                'secondary' => $member->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'icon' => __('icons.show'),
                            ],
                            'attrs' => [
                                'href' => url("members/{$member->user_id}")
                            ]
                        ];
                    }),                    
                ]
            ]) @endpaginable        
        @endcell        
    @endgridWithInner
@endsection
