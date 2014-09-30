<?php namespace Streams\Platform\Provider;

class FilterServiceProvider extends \Illuminate\Routing\FilterServiceProvider
{
    /**
     * Filters to run before requests.
     *
     * @var array
     */
    protected $before = [
        'Streams\Platform\Http\Filter\StartFilter',
        'Streams\Platform\Http\Filter\InstallerFilter',
        'Streams\Platform\Http\Filter\LocaleFilter',
        'Streams\Platform\Http\Filter\SetupThemeFilter',
        'Streams\Platform\Http\Filter\SetupModuleFilter',
    ];

    /**
     * Filters to run after requests.
     *
     * @var array
     */
    protected $after = [];

    /**
     * All available route filters.
     *
     * @var array
     */
    protected $filters = [
        'auth' => 'Streams\Platform\Http\Filter\AuthFilter',
        'csrf' => 'Streams\Platform\Http\Filter\CsrfFilter',
    ];
}
