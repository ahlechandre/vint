{{-- Layout --}}
@extends('layouts.master', [
    'title' => __('resources.users')
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
                'title' => __('resources.users'),
                'content' => __('messages.users.index'),
            ]) @endheading        
        @endcell
        
        @cell
            {{-- Paginável --}}
            @paginable([
                'paginator' => $users,
                'withMenu' => true, 
                'list' => [
                    'isNavigation' => true,
                    'twoLine' => true,
                    'items' => $users->map(function ($userToShow) {
                        return [
                            'letter' => substr($userToShow->name, 0, 1),
                            'text' => [
                                'primary' => $userToShow->name,
                                'secondary' => $userToShow->created_at
                                    ->diffForHumans(),
                            ],
                            'attrs' => [
                                'href' => url("users/{$userToShow->id}")
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ],
                        ];
                    }),                    
                ]
            ]) @endpaginable        
        @endcell
        
        {{-- Novo --}}
        @can('create', \Modules\User\Entities\User::class)
            @fabFixed([
                'fab' => [
                    'isLink' => true,
                    'icon' => __('icons.add'),
                    'attrs' => [
                        'href' => url('users/create'),
                        'title' => __('messages.users.forms.create_title'),
                        'alt' => __('messages.users.forms.create_title')
                    ],
                ]
            ]) @endfabFixed
        @endcan
    @endgridWithInner
@endsection
