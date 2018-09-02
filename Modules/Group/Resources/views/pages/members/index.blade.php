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
                            'href' => url("groups/{$group->id}/members/requests")
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
                    'nonInteractive' => true,
                    'items' => $members->map(function ($member) use ($user, $group) {
                        return [
                            'icon' => __('icons.member'),
                            'text' => [
                                'link' => url("members/{$member->user_id}"),
                                'primary' => $member->user->name,
                                'secondary' => $member->created_at
                                    ->diffForHumans(),
                            ],
                            'metas' => array_merge(
                                auth()->check() && $user->can('detachMember', [$group, $member]) ? 
                                [
                                    [
                                        'dialogContainer' => [
                                            'iconButton' => [
                                                'icon' => __('icons.deny')
                                            ],
                                            'form' => [
                                                'action' => url("groups/{$group->id}/members/{$member->user_id}"),
                                                'method' => 'delete'
                                            ],
                                            'dialog' => [
                                                'title' => __('messages.groups.members.dialogs.remove_title'),
                                                'attrs' => [
                                                    'id' => "dialog-group-member-remove-{$member->user_id}"
                                                ],
                                                'footer' => [
                                                    'buttonAccept' => [
                                                        'text' => __('actions.confirm'),
                                                        'attrs' => [
                                                            'type' => 'submit' 
                                                        ]
                                                    ],
                                                    'buttonCancel' => [
                                                        'text' => __('actions.cancel'),
                                                        'attrs' => [
                                                            'type' => 'button' 
                                                        ]
                                                    ]                                                    
                                                ]
                                            ]
                                        ]                                    
                                    ]                                
                                ] :
                                [], 
                                [
                                    [
                                        'iconButton' => [
                                            'isLink' => true,
                                            'icon' => __('icons.show'),
                                            'attrs' => [
                                                'href' => url("members/{$member->user_id}")
                                            ]
                                        ]
                                    ]
                                ]
                            ),
                        ];
                    }),                    
                ]
            ]) @endpaginable
        @endcell
    @endgridWithInner
@endsection
