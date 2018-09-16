@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.publications'),
        __('messages.publications.name', [
            'id' => $publication->id
        ]),
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
            @headingPublication([
                'publication' => $publication,
                'tabActive' => 'members',
            ]) @endheadingPublication
        @endcell

        @cell
            @paginable([
                'paginator' => $members,
                'list' => [
                    'twoLine' => true,
                    'isNavigation' => true,
                    'items' => $members->map(function ($member) use ($user) {
                        return [
                            'icon' => __('icons.project'),
                            'text' => [
                                'primary' => $member->user->name,
                                'secondary' => $member->created_at
                                    ->diffForHumans(),
                            ],
                            'attrs' => [
                                'href' => url("members/{$member->user_id}")
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ],
                        ];
                    }),
                ]
            ]) @endpaginable
        @endcell
    @endgridWithInner
@endsection
