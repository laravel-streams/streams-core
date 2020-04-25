<?php

namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\Streams\Platform\Stream\StreamRegistry;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesApi;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesAssets;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesRoutes;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesCommands;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesListeners;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesMiddleware;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesPolicies;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesProviders;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesSchedules;
use Anomaly\Streams\Platform\Provider\Concerns\ProvidesStreams;
use Anomaly\Streams\Platform\Traits\HasMemory;

/**
 * Class ServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    use Hookable;
    use HasMemory;

    use ProvidesApi;
    use ProvidesAssets;
    use ProvidesRoutes;
    use ProvidesStreams;
    use ProvidesCommands;
    use ProvidesPolicies;
    use ProvidesListeners;
    use ProvidesProviders;
    use ProvidesSchedules;
    use ProvidesMiddleware;

    /**
     * Register common provisions.
     */
    protected function registerCommon()
    {
        $this->registerApi();
        $this->registerAssets();
        $this->registerRoutes();
        $this->registerCommands();
        $this->registerPolicies();
        $this->registerListeners();
        $this->registerProviders();
        $this->registerSchedules();
        $this->registerMiddleware();
    }
}
