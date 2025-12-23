@if (setting('language_switcher', 'permission'))
    <div class="language-button {{ $langSwitcherClass ?? '' }}">
        <select onchange="window.location.href=this.value" class="nice-select-active">
            @foreach (\App\Models\Language::where('status', 1)->get() as $lang)
                <option value="{{ route('language-update', ['name' => $lang->locale]) }}" @selected(app()->getLocale() == $lang->locale)>
                    {{ $lang->name }}</option>
            @endforeach
        </select>
    </div>
@endif
