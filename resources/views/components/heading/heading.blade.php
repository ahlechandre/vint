<div class="heading">
    
    <div class="heading__title">
        @if ($pretitle ?? false)
            <p class="heading__pretitle-text">
                {{ $pretitle }}
            </p>
        @endif

        <h1 class="heading__title-text">{{ $title }}</h1>
    </div>
    
    @if ($content ?? false)
        <div class="heading__content">
            <p class="heading__content-text">{{ $content }}</p>
        </div>
    @endif

    @if ($tabBar ?? false)
        <div class="heading__tab-bar">
            @tabBar($tabBar) @endtabBar        
        </div>
    @endif
</div>