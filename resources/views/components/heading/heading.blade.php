<div class="heading">

    <div class="heading__primary">
        @if ($action ?? false)
            <div class="heading__action">
                @if ($action['button'] ?? false)
                    @button($action['button']) @endbutton
                @elseif ($action['iconButton'] ?? false) 
                    @iconButton($action['iconButton']) @endiconButton
                @elseif ($action['dialogContainer'] ?? false) 
                    @dialogContainer($action['dialogContainer']) @enddialogContainer
                @endif
            </div>
        @endif
        
        <div class="heading__title">
            @if ($pretitle ?? false)
                <p class="heading__pretitle-text">
                    {{ $pretitle }}
                </p>
            @endif

            <h1 class="heading__title-text mdc-typography--headline4">{{ $title }}</h1>
        </div>    
    </div>    
    
    @if ($content ?? false)
        <div class="heading__content">
            <p class="heading__content-text mdc-typography--headline7">{{ $content }}</p>
        </div>
    @endif

    @if ($tabBar ?? false)
        <div class="heading__tab-bar">
            @tabBar($tabBar) @endtabBar        
        </div>
    @endif
</div>