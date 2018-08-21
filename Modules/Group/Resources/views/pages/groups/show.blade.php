@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.groups'),
            'attrs' => [
                'href' => url('groups')
            ]
        ],
        [
            'text' => $group->name,
            'attrs' => [
                'href' => url("groups/{$group->id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=about")
                ],
            ],
            [
                'text' => __('resources.coordinators'),
                'isActive' => $section === 'coordinators',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=coordinators")
                ],
            ],
            [
                'text' => __('resources.members'),
                'isActive' => $section === 'members',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=members")
                ],
            ],
            [
                'text' => __('resources.programs'),
                'isActive' => $section === 'programs',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=programs")
                ],
            ],
            [
                'text' => __('resources.projects'),
                'isActive' => $section === 'projects',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=projects")
                ],
            ],
            [
                'text' => __('resources.roles'),
                'isActive' => $section === 'group-roles',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=group-roles")
                ],
            ]            
        ]
    ],
])
@section('title', __('resources.groups') . " / {$group->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                {{-- "Sobre" --}}
                @component('group::pages.groups.sections.about', [
                    'group' => $group
                ]) @endcomponent
            @elseif ($section === 'coordinators')
                {{-- "Coordenadores" --}}
                @component('group::pages.groups.sections.coordinators', [
                    'group' => $group,
                    'professors' => $professors,
                ]) @endcomponent                
            @elseif ($section === 'members')
                {{-- "Membros" --}}
                @component('group::pages.groups.sections.members', [
                    'group' => $group,
                    'members' => $members,
                    'membersNotApproved' => $membersNotApproved,
                ]) @endcomponent
            @elseif ($section === 'group-roles')
                {{-- "Papéis" --}}
                @component('group::pages.groups.sections.group-roles', [
                    'group' => $group,
                    'permissions' => $permissions
                ]) @endcomponent                
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
