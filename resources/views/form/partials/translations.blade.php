<div style="display: inline-block;">
    <button>
        {{ trans('streams::locale.' . $fieldType->getLocale() . '.name') }}
    </button>
    <div class="dropdown-menu">
        @foreach (config('streams::locales.enabled', []) as $iso)
            <a class="dropdown-item {{ $iso == config('streams::locales.default') ? 'active' : null }}"
               href="#"
               data-toggle="lang" lang="{{ $iso }}">
                {{ trans('streams::locale.' . $iso . '.name') }}
            </a>
        @endforeach
    </div>
</div>
