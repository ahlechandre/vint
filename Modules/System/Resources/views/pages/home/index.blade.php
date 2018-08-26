@extends('layouts.home', [
    'title' => __('headlines.homepage')
]) 

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        @cell
            <h1>...</h1>
        @endcell

        @cell
            <div>
                <h3>button</h3>
                @button([
                    'classes' => ['mdc-button--outlined'],
                    'icon' => 'arrow_forward'
                ]) Hello, world! @endbutton    
            </div>        
        @endcell

        @cell
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
        
        @endcell

        @cell
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
        @endcell

        @cell
            <div>
                <h3>shape</h3>

                @shapeButton([
                    'button' => [
                        'classes' => ['mdc-button--unelevated'],
                        'icon' => 'arrow_forward',
                        'text' => 'hello world'
                    ]
                ]) @endshapeButton

                @shapeCard([
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
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni necessitatibus maiores assumenda quia iure nihil aspernatur doloremque qui, quaerat distinctio eum officia et, incidunt quibusdam quisquam saepe! Nobis, perferendis blanditiis.
                @endshapeCard        
            </div>
        
        @endcell

        @cell
            <div>
                <h3>dialog</h3>
                
                @dialogContainer([
                    'shapeButton' => [
                        'button' => [
                            'text' => 'dialog',
                            'classes' => ['mdc-button--outlined']
                        ]
                    ],
                    'dialog' => [
                        'attrs' => [
                            'id' => 'dialog-1',
                        ], 
                        'scrollable' => true,
                        'title' => 'dialog title',
                        'footer' => [
                            'buttonAccept' => [
                                'text' => 'accept',
                                'attrs' => [
                                    'type' => 'button'
                                ],
                            ],
                            'buttonCancel' => [
                                'text' => 'cancel',
                                'attrs' => [
                                    'type' => 'button'
                                ],
                            ],
                        ]                        
                    ]
                ])
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti illum veniam possimus veritatis error? Voluptas qui, sint, ab placeat quia tenetur ratione, impedit labore error quibusdam ipsa atque minus natus?

                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. In maiores quaerat, pariatur ratione similique atque repellat delectus ipsam nisi temporibus aliquid ad sed ducimus excepturi cumque nobis quibusdam minima dolorem!

                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti illum veniam possimus veritatis error? Voluptas qui, sint, ab placeat quia tenetur ratione, impedit labore error quibusdam ipsa atque minus natus?

                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. In maiores quaerat, pariatur ratione similique atque repellat delectus ipsam nisi temporibus aliquid ad sed ducimus excepturi cumque nobis quibusdam minima dolorem!

                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti illum veniam possimus veritatis error? Voluptas qui, sint, ab placeat quia tenetur ratione, impedit labore error quibusdam ipsa atque minus natus?

                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. In maiores quaerat, pariatur ratione similique atque repellat delectus ipsam nisi temporibus aliquid ad sed ducimus excepturi cumque nobis quibusdam minima dolorem!

                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deleniti illum veniam possimus veritatis error? Voluptas qui, sint, ab placeat quia tenetur ratione, impedit labore error quibusdam ipsa atque minus natus?

                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. In maiores quaerat, pariatur ratione similique atque repellat delectus ipsam nisi temporibus aliquid ad sed ducimus excepturi cumque nobis quibusdam minima dolorem!                                                 
                @enddialogContainer
            </div>
        @endcell

        @cell
            <div>
                <h3>lists</h3>

                @list([
                    'twoLine' => true,
                    'isNavigation' => true,
                    'items' => [
                        [
                            'icon' => 'wifi',
                            'attrs' => [
                                'href' => '#',    
                            ],
                            'text' => [
                                'primary' => 'item 1',
                                'secondary' => 'item 1 desc',
                            ],
                            'meta' => [
                                'iconButton' => [
                                    'icon' => 'add',
                                    'attrs' => [
                                        'href' => '#!'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'text' => 'item 2'
                        ],
                        [
                            'text' => 'item 3'
                        ]        
                    ]
                ]) @endlist                
            </div>
        @endcell

        @cell
            <h3>menus</h3>

            @menuAnchor([
                'button' => [
                    'text' => 'menu',
                ],
                'menu' => [
                    'list' => [
                        'isNavigation' => true,
                        'items' => [
                            [
                                'text' => 'item 1',
                                'attrs' => [
                                    'href' => '#!1'
                                ]
                            ],
                            [
                                'text' => 'item 2',
                                'attrs' => [
                                    'href' => '#!2'
                                ]                                
                            ],
                        ]
                    ]
                ]
            ]) @endmenuAnchor

            @menuAnchor([
                'button' => [
                    'classes' => ['mdc-button--outlined'],
                    'text' => 'menu',
                ],
                'menu' => [
                    'list' => [
                        'items' => [
                            [
                                'text' => 'dialog',
                                'classes' => ['dialog-activation'],
                                'attrs' => [
                                    'data-dialog-activation' => 'dialog-2',
                                    'data-vint-auto-init' => 'VintDialogActivation'
                                ]
                            ],
                        ]
                    ]
                ]
            ]) @endmenuAnchor
            
            @dialog([
                'title' => 'open by menu',
                'attrs' => [
                    'id' => 'dialog-2'
                ],
                'footer' => [
                    'buttonAccept' => [
                        'text' => 'ok'
                    ]
                ]
            ]) @enddialog
        @endcell

        @cell
            @heading([
                'pretitle' => 'Pretitle',
                'title' => 'Heading title',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eius quas enim earum, ad aliquid esse odio quidem nam suscipit? Nesciunt odio velit quis dolores neque officiis, sequi nobis repudiandae quasi.',
                'action' => [
                    'shapeButton' => [
                        'button' => [
                            'text' => 'view all',
                            'classes' => ['mdc-button--outlined']
                        ]
                    ]
                ]
            ]) @endheading
        @endcell

        @cell
            <h3>chips</h3>

            @chipSet 
                @chip([
                    'iconTrailing' => true,
                    'icon' => 'cancel',
                    'text' => 'Hello world'
                ]) @endchip

                @chip([
                    'icon' => 'check',
                    'text' => 'Hello world'
                ]) @endchip
            @endchipSet 
        @endcell

        @cell
            <h3>tab bar</h3>

            @tabBar([
                'tabs' => [
                    [
                        'active' => true,
                        'icon' => 'add',
                        'label' => 'item 1',
                        'classes' => ['mdc-tab--stacked'],
                        'restrictIndicator' => true,
                    ],
                    [
                        'icon' => 'close',
                        'label' => 'item 2',
                        'classes' => ['mdc-tab--stacked'],
                        'restrictIndicator' => true,
                    ],
                ]
            ]) @endtabBar
        @endcell

        @cell
            <h3>inputs</h3>

            <div>
                @checkbox([
                    'label' => 'checkbox 1',
                    'attrs' => [
                        'id' => 'checkbox-1'
                    ],
                ]) @endcheckbox
            </div>

            <div>
                @radio([
                    'label' => 'radio 1',
                    'attrs' => [
                        'id' => 'radio-1'
                    ],
                ]) @endradio
            </div>

            <div>
                @switchControl([
                    'label' => 'switch 1',
                    'attrs' => [
                        'id' => 'switch-1'
                    ],
                ]) @endswitchControl
            </div>

            <div>
                @select([
                    'label' => 'select 1',
                    'attrs' => [
                        'id' => 'select-1'
                    ],
                    'options' => [
                        [
                            'text' => '',
                            'attrs' => [
                                'value' => '',
                                'disabled' => '',
                                'selected' => ''
                            ],
                        ],
                        [
                            'text' => 'option 1',
                            'attrs' => [
                                'value' => '1',
                            ],
                        ],
                        [
                            'text' => 'option 2',
                            'attrs' => [
                                'value' => '2',
                            ],
                        ]       
                    ]
                ]) @endselect                
            </div>

            <div>
                @select([
                    'label' => 'select 2',
                    'attrs' => [
                        'id' => 'select-2'
                    ],
                    'options' => [
                        [
                            'text' => '',
                            'attrs' => [
                                'value' => '',
                                'disabled' => '',
                                'selected' => ''
                            ],
                        ],
                        [
                            'text' => 'option 1',
                            'attrs' => [
                                'value' => '1',
                                'selected' => ''
                            ],
                        ],
                        [
                            'text' => 'option 2',
                            'attrs' => [
                                'value' => '2',
                            ],
                        ]       
                    ]
                ]) @endselect            
            </div>
            
            <div>
                @textfield([
                    'label' => 'textfield 1',
                    'attrs' => [
                        'id' => 'textfield-1'
                    ]
                ]) @endtextfield
            </div>

            <div>
                @textfield([
                    'label' => 'textfield 2',
                    'attrs' => [
                        'id' => 'textfield-2',
                        'value' => 'text value'
                    ]
                ]) @endtextfield
            </div>

            <div>
                @textarea([
                    'label' => 'Textarea',
                    'attrs' => [
                        'id' => 'textarea-1',
                    ]
                ]) @endtextarea
            </div>

            <div>
                @select2([
                    'label' => 'Single',
                    'componentAttrs' => [
                        'id' => 'select2-single'
                    ], 
                    'options' => [
                        [
                            'text' => 'select single',
                            'attrs' => [
                                'value' => '',
                                'selected' => '',
                                'disabled' => '',
                            ]
                        ]
                    ]
                ]) @endselect2
            </div>

            <div>
                @select2([
                    'label' => 'Multiple',
                    'componentAttrs' => [
                        'id' => 'select2-multiple'
                    ], 
                    'attrs' => [
                        'multiple' => ''
                    ]
                ]) @endselect2
            </div>            
        @endcell

        {{-- Spacing --}}
        @cell @endcell
        @cell @endcell
        @cell @endcell
        @cell @endcell
        @cell @endcell
        @cell @endcell
        @cell @endcell
        @cell @endcell
    @endgridWithInner
@endsection

@section('scripts')
    <script>
        (() => {
            const s = () => {
                // Single
                const single = () => {
                    const element = document.querySelector('#select2-single')
                    const select2 = new window.vint.VintSelect2(element)
                    select2.render({
                        ajax: {
                            url: '/api/choices',
                            processResults: response => ({
                                results: response.data.map(item => ({
                                    id: item.id,
                                    text: item.name,
                                })),
                            }),
                            data: params => ({
                                q: params.term,
                                'per-page': 10 
                            })
                        }
                    })                    
                }
                // Multiple.
                const multiple = () => {
                    const element = document.querySelector('#select2-multiple')
                    const select2 = new window.vint.VintSelect2(element)
                    select2.render({
                        placeholder: 'chooseeeee',
                        ajax: {
                            url: '/api/choices',
                            processResults: response => ({
                                results: response.data.map(item => ({
                                    id: item.id,
                                    text: item.name,
                                })),
                            }),
                            data: params => ({
                                q: params.term,
                                'per-page': 10 
                            })
                        }
                    })                    
                }
                single()
                multiple()                   
            }

            window.addEventListener('load', () => {
                setTimeout(s, 1)
            })
        })()
    </script>
@endsection