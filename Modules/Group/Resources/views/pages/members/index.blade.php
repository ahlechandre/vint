@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.groups').' / '.$group->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingGroup([
                'group' => $group,
                'tabActive' => 'members',
            ]) @endheadingGroup
        @endcell
        
        {{-- Solicitações --}}
        @can('updateMembersRequests', $group)
            @if ($requestsCount > 0)
                @cell([
                    'classes' => ['mdc-layout-grid--align-right']
                ])
                    @button([
                        'isLink' => true,
                        'icon' => __('icons.forward'),
                        'text' => __('headlines.requests') . (
                            $requestsCount > 99 ?
                                ' (+99)' : " ($requestsCount)"
                        ),
                        'attrs' => [
                            'href' => url("groups/{$group->id}/members-requests")
                        ]
                    ]) @endbutton
                @endcell
            @endif
        @endcan

        {{-- Paginável --}}
        @cell
            @paginable([
                'paginator' => $members,
                'list' => [
                    'twoLine' => true,
                    'isNavigation' => true,
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
