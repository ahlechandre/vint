@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.groups'),
        $group->name,
        __('resources.programs'),
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
                'tabActive' => 'programs',
            ]) @endheadingGroup
        @endcell
        
        {{-- Solicitações --}}
        @can('updateRequests', [\Modules\Project\Entities\Program::class, $group])
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
                            'href' => url("groups/{$group->id}/programs/requests")
                        ]
                    ]) @endbutton
                @endcell
            @endif
        @endcan

        {{-- Paginável --}}
        @cell
            @paginable([
                'paginator' => $programs,
                'list' => [
                    'twoLine' => true,
                    'nonInteractive' => true,
                    'items' => $programs->map(function ($program) use ($user, $group) {
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

            {{-- Novo --}}
            @can('create', [\Modules\Project\Entities\Program::class, $group])
                @fabFixed([
                    'fab' => [
                        'isLink' => true,
                        'icon' => __('icons.add'),
                        'attrs' => [
                            'href' => url("groups/{$group->id}/programs/create"),
                            'title' => __('messages.groups.programs.forms.create_title'),
                        ],
                    ]
                ]) @endfabFixed
            @endcan
        @endcell
    @endgridWithInner
@endsection
