@extends('layouts.auth', [
    'title' => __('actions.login')
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--superdense']
        ]
    ])
        @cell
            {{-- Login card --}}
            @card([
                'classes' => ['card--login']
            ])
                @cardHeader
                    @heading([
                        'title' => __('messages.login.card_title'),
                        'content' => __('messages.login.redirect'),
                    ]) @endheading                
                @endcardHeader

                @cardContent
                    @form([
                        'action' => url('login'),
                        'method' => 'post',
                        'inputs' => [
                            'view' => 'system::inputs.login'
                        ]
                    ]) @endform                
                @endcardContent            
            @endcard
        @endcell
    @endgridWithInner
@endsection 