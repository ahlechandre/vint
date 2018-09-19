@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'withoutAnimation' => true,
    'title' => get_breadcrumb([
        __('resources.groups'),
        $group->name,
        __('resources.members'),
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
            @headingGroup([
                'group' => $group,
                'tabActive' => 'members',
            ]) @endheadingGroup
        @endcell
        
        {{-- Solicitações --}}
        @can('updateRequests', [\Modules\Member\Entities\Member::class, $group])
            @if ($requestsCount > 0)
                @cell
                    @button([
                        'isLink' => true,
                        'icon' => __('icons.forward'),
                        'classes' => ['mdc-button--outlined'],
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
                            'letter' => substr($member->user->name, 0, 1),
                            'text' => [
                                'link' => url("members/{$member->user_id}"),
                                'primary' => $member->user->name,
                                'secondary' => $member->created_at
                                    ->diffForHumans(),
                            ],
                            'metas' => array_merge(
                                $user && $user->can('detachMember', [$group, $member]) ? 
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
                                                'title' => __('dialogs.groups.detach_member_title'),
                                                'text' => __('dialogs.groups.detach_member_body'),
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
