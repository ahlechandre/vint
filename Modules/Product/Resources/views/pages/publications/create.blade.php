@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.publications'),
            'attrs' => [
                'href' => url('publications')
            ]
        ],
        [
            'text' => __('actions.create'),
            'attrs' => [
                'href' => url('/publications/create')
            ]
        ]
    ],
])
@section('title', __('resources.publications') . ' / ' . __('actions.create'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => __('resources.publications'),
                'subtitle' => __('messages.publications.create'),
            ])
                @form([
                    'action' => url('publications'),
                    'method' => 'post',
                    'attrs' => [
                        'id' => 'form-publication'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,  
                    'inputs' => [
                        'view' => 'product::inputs.publication',
                        'props' => [
                            'reference' => old('reference'),
                            'url' => old('url'),
                            'projectsId' => old('projects'),
                            'membersUserId' => old('projects'),
                            'projects' => $projects,
                            'members' => $members,
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner
@endsection
