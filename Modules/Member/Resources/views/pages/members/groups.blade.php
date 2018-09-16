@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.members'),
        $member->user->name,
        __('resources.groups')        
    ])  
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingMember([
                'member' => $member,
                'tabActive' => 'groups',
            ]) @endheadingMember
        @endcell

        @cell
            @paginable([
                'paginator' => $groups,
                'list' => [
                    'twoLine' => true,
                    'nonInteractive' => true,
                    'items' => $groups->map(function ($group) use ($user) {
                        return [
                            'icon' => __('icons.group'),
                            'text' => [
                                'link' => url("groups/{$group->id}"),
                                'primary' => $group->name,
                                'secondary' => $group->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'iconButton' => [
                                    'isLink' => true,
                                    'icon' => __('icons.show'),
                                    'attrs' => [
                                        'href' => url("groups/{$group->id}")
                                    ]
                                ]
                            ],
                        ];
                    }),                    
                ]
            ]) @endpaginable
        @endcell
    @endgridWithInner
@endsection
