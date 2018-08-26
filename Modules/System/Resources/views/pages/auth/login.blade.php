@extends('layouts.default', [
    'title' => __('actions.login')
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--superdense']
        ]
    ])
        @cell
            @cardLogin([
                'title' => __('actions.login'),
                'subtitle' => __('messages.actions.login_subtitle'),
            ])
                @form([
                    'action' => url('login'),
                    'method' => 'post',
                    'inputs' => [
                        'view' => 'system::inputs.login'
                    ]
                ]) @endform
            @endcardLogin
        @endcell
    @endgridWithInner
@endsection 