<?php namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewCollection;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ViewCollection::class,
        ];
    }

    public function register()
    {
        //View::share
    }
}
