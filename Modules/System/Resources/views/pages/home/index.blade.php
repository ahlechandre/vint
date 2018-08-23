@extends('layouts.home', [
    'title' => __('headlines.homepage')
]) 

@section('main')
    <h1>Bem vindo ao VINT</h1>

    <div>
        <h3>button</h3>
        @button([
            'classes' => ['mdc-button--outlined'],
            'icon' => 'arrow_forward'
        ]) Hello, world! @endbutton    
    </div>

    <div>
        <h3>fab</h3>
        @fab([
            'icon' => 'add',
            'attrs' => [
                'href' => '#!'
            ],
        ]) @endfab

        @fabFixed([
            'fab' => [
                'icon' => 'add',
                'classes' => ['mdc-fab--extended'],
                'label' => 'Create',
                'attrs' => [
                    'href' => '#!'
                ],
            ]
        ]) @endfabFixed        
    </div>

    <div>
        <h3>card</h3>

        @card([
            'actions' => [
                'buttons' => [
                    [
                        'isLink' => true,
                        'text' => 'action 1',
                        'attrs' => [
                            'href' => '#!!'
                        ],
                    ]
                ],
                'icons' => [
                    [
                        'isLink' => true,
                        'icon' => 'more_vert',
                        'attrs' => [
                            'href' => '#!'
                        ],
                    ]
                ]
            ]
        ])
            <h4>title</h4>
            <p>subtitle</p>
        @endcard
        
        <h3>card paper</h3>
        
        @cardPaper([
            'title' => 'Title',
            'subtitle' => 'Title',
            'card' => [
                'actions' => [
                    'buttons' => [
                        [
                            'isLink' => true,
                            'text' => 'action 1',
                            'attrs' => [
                                'href' => '#!!'
                            ],
                        ]
                    ],
                    'icons' => [
                        [
                            'isLink' => true,
                            'icon' => 'more_vert',
                            'attrs' => [
                                'href' => '#!'
                            ],
                        ]
                    ]
                ]                
            ]
        ])
            content here...
        @endcardPaper
    </div>

    <div>
        <h3>shape</h3>

        @shapeButton
            @button([
                'classes' => ['mdc-button--unelevated'],
                'icon' => 'arrow_forward'
            ]) Hello, world! @endbutton
        @endshapeButton

        @shapeCard
            @cardPaper([
                'title' => 'Title',
                'subtitle' => 'Title',
                'card' => [
                    'classes' => ['mdc-card--outlined'],
                    'actions' => [
                        'icons' => [
                            [
                                'isLink' => true,
                                'icon' => 'more_vert',
                                'attrs' => [
                                    'href' => '#!'
                                ],
                            ]
                        ]
                    ]                
                ]
            ])
                content here... Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio quam tenetur accusamus, quod tempore vero nobis. 
            @endcardPaper
        @endshapeCard        
    </div>

@endsection