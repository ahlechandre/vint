@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.members'),
        $member->user->name,
        __('resources.programs')        
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
                'tabActive' => 'programs',
            ]) @endheadingMember
        @endcell

        @cell
            @paginable([
                'paginator' => $programs,
                'list' => [
                    'twoLine' => true,
                    'nonInteractive' => true,
                    'items' => $programs->map(function ($program) use ($user) {
                        return [
                            'icon' => __('icons.program'),
                            'text' => [
                                'link' => url("programs/{$program->id}"),
                                'primary' => $program->name,
                                'secondary' => $program->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'iconButton' => [
                                    'isLink' => true,
                                    'icon' => __('icons.show'),
                                    'attrs' => [
                                        'href' => url("programs/{$program->id}")
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
