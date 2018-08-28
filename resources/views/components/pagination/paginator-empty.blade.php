<div class="paginator-empty">
    @if ($search ?? false)
        <h3>{{ __('messages.pagination.is_empty_search', [
            'query' => $search
        ]) }}</h3>
    @else
        <h3>{{ __('messages.pagination.is_empty') }}</h3>    
    @endif
</div>