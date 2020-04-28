<?php

namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Traits\Hookable;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersApi;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersAssets;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersRoutes;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersStreams;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersCommands;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersPolicies;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersListeners;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersProviders;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersSchedules;
use Anomaly\Streams\Platform\Provider\Concerns\RegistersMiddleware;

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

    use RegistersApi;
    use RegistersAssets;
    use RegistersRoutes;
    use RegistersStreams;
    use RegistersCommands;
    use RegistersPolicies;
    use RegistersListeners;
    use RegistersProviders;
    use RegistersSchedules;
    use RegistersMiddleware;

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
