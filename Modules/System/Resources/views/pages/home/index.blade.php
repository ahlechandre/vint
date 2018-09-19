@extends('layouts.default', [
    'withoutLoginAction' => true,
    'title' => __('headlines.homepage')
]) 

@section('main')
<div class="homepage">
    <div class="homepage__section">
        @gridWithInner([
            'grid' => [
                'classes' => ['layout-grid--dense']
            ]
        ])
            @cell([
                'when' => ['d' => 12, 't' => 8]
            ])
                <div class="homepage__intro">
                    <h1 class="mdc-typography--headline4">
                        {{ __('messages.homepage.intro') }}               
                    </h1>

                    <div class="homepage__intro-actions">     
                        @button([
                            'isLink' => true,
                            'icon' => __('icons.login'),
                            'text' => __('actions.login'),
                            'classes' => [
                                'mdc-button--unelevated',
                                'homepage__intro-action-button'
                            ],
                            'attrs' => [
                                'href' => url('login'),
                                'title' => __('actions.login')
                            ],
                        ]) @endbutton                    
                    </div>                
                </div>
            @endcell

            @cell([
                'when' => ['d' => 12, 't' => 8]
            ])
                @list([
                    'classes' => ['mdc-list--avatar-list'],
                    'isNavigation' => true,
                    'nonInteractive' => true,
                    'items' => [
                        [
                            'icon' => __('icons.groups'),
                            'text' => __('resources.groups'),
                            'attrs' => [
                                'href' => url('groups')
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ]                            
                        ],
                        [
                            'icon' => __('icons.members'),
                            'text' => __('resources.members'),
                            'attrs' => [
                                'href' => url('members')
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ]
                        ],
                        [
                            'icon' => __('icons.programs'),
                            'text' => __('resources.programs'),
                            'attrs' => [
                                'href' => url('programs')
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ]                            
                        ],
                        [
                            'icon' => __('icons.projects'),
                            'text' => __('resources.projects'),
                            'attrs' => [
                                'href' => url('projects')
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ]                            
                        ],
                        [
                            'icon' => __('icons.products'),
                            'text' => __('resources.products'),
                            'attrs' => [
                                'href' => url('products')
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ]                            
                        ],
                        [
                            'icon' => __('icons.publications'),
                            'text' => __('resources.publications'),
                            'attrs' => [
                                'href' => url('publications')
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ]
                        ]                        
                    ],
                ]) @endlist
            @endcell            
        @endgridWithInner
    </div>
</div>
@endsection