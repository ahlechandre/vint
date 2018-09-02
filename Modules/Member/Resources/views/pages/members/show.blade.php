@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.members').' / '.$member->user->name 
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
                'tabActive' => 'about',
            ]) @endheadingMember
        @endcell

        @cell
            {{-- Informações --}}
            @foreach($member->getAttributes() as $attr => $value)
                <p>
                    {{ $attr }} => {{ $value }}
                </p>
            @endforeach

        @endcell
    @endgridWithInner
@endsection
