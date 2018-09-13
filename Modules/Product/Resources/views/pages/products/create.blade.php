@extends('layouts.master', [
    'title' => __('resources.products').' / '.__('actions.new') 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @heading([
                'pretitle' => __('resources.products'),
                'title' => __('messages.products.create'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url('products'),
                'method' => 'post',
                'attrs' => [
                    'id' => 'form-product',
                    'data-vint-auto-init' => 'VintFormProduct'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'product::inputs.product',
                    'props' => [
                        'title' => old('title'),
                        'description' => old('description'),
                        'url' => old('url'),
                        'projects' => old('projects') ?
                            \Modules\Project\Entities\Project::forUser($user)
                                ->with('group')
                                ->find(old('projects'))
                        : null
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
