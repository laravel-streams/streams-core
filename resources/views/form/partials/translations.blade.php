<div style="display: none;">
    <button type="button">
        {{ trans('streams::locale.' . $fieldType->getLocale() . '.name') }}
    </button>
    <div class="dropdown-menu">
        @foreach (config('streams::locales.enabled', []) as $iso)
            <button type="button" class="dropdown-item {{ $iso == config('streams::locales.default') ? 'active' : null }}"
               href="#"
               data-toggle="lang" lang="{{ $iso }}">
                {{ trans('streams::locale.' . $iso . '.name') }}
            </button>
        @endforeach
    </div>
</div>
