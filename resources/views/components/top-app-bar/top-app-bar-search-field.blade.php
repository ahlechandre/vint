<form action="{{ request()->segment(1) === 'search' ?
    url()->current() : url('search') }}"
    class="top-app-bar__form">
    <input type="text"
        name="q"
        placeholder="{{ __('actions.search') }}"
        value="{{ request()->query('q') }}"
        class="top-app-bar__text-field">
</form>