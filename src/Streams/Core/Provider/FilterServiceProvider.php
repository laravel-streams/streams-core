<?php namespace Streams\Core\Provider;

use Illuminate\Routing\FilterServiceProvider as ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{

    /**
     * The filters that should run before all requests.
     *
     * @var array
     */
    protected $before = [
        'Streams\Core\Http\Filter\BootFilter',
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
        'auth'  => 'Streams\Core\Http\Filter\AuthFilter',
        'csrf'  => 'Streams\Core\Http\Filter\CsrfFilter',
        'guest' => 'Streams\Core\Http\Filter\GuestFilter',
    ];

}
