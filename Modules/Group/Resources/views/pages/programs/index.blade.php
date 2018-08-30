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
                'tabActive' => 'programs',
            ]) @endheadingGroup
        @endcell
        
        {{-- Solicitações --}}
        @can('updateRequests', [\Modules\Project\Entities\Program::class, $group])
            @cell([
                'classes' => ['mdc-layout-grid--align-right']
            ])
                @if ($programRequestsCount > 0)
                    @button([
                        'isLink' => true,
                        'icon' => __('icons.forward'),
                        'text' => __('headlines.requests') . (
                            $programRequestsCount > 99 ?
                                ' (+99)' : " ($programRequestsCount)"
                        ),
                        'attrs' => [
                            'href' => url("groups/{$group->id}/program-requests")
                        ]
                    ]) @endbutton
                @else
                    @button([
                        'icon' => __('icons.forward'),
                        'text' => __('headlines.requests'),
                        'attrs' => [
                            'disabled' => ''
                        ]
                    ]) @endbutton                
                @endif
            @endcell
        @endcan

        {{-- Paginável --}}
        @cell
            @paginable([
                'paginator' => $programs,
                'items' => $programs->map(function ($program) {
                    return [
                        'text' => [
                            'primary' => $program->name,
                            'secondary' => $program->created_at
                                ->diffForHumans(),
                        ],
                        'meta' => [
                            'icon' => __('icons.show'),
                        ],
                        'attrs' => [
                            'href' => url("programs/{$program->id}")
                        ]
                    ];
                }),
            ]) @endpaginable

            {{-- Novo --}}
            @can('create', [\Modules\Project\Entities\Program::class, $group])
                @fabFixed([
                    'fab' => [
                        'isLink' => true,
                        'icon' => __('icons.add'),
                        'classes' => ['mdc-fab--extended'],
                        'label' => __('actions.new'),
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
