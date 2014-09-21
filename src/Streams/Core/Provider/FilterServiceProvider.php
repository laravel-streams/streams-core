<?php namespace Streams\Platform\Provider;

use Illuminate\Routing\FilterServiceProvider as ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{

    /**
     * The filters that should run before all requests.
     *
     * @var array
     */
    protected $before = [
        'Streams\Platform\Http\Filter\BootFilter',
    ];

    /**
     * The filters that should run after all requests.
     *
     * @var array
     */
    protected $after = [
        //
    ];

    /**
     * All available route filters.
     *
     * @var array
     */
    protected $filters = [
        'auth'  => 'Streams\Platform\Http\Filter\AuthFilter',
        'csrf'  => 'Streams\Platform\Http\Filter\CsrfFilter',
        'guest' => 'Streams\Platform\Http\Filter\GuestFilter',
    ];

}
