<?php

namespace Anomaly\Streams\Platform\Model;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EloquentFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EloquentFactory
{
    use DispatchesJobs;
    use FiresCallbacks;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new EloquentFactory instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make a new EntryBuilder instance.
     *
     * @param         $model
     * @param  string $method
     * @return EloquentCriteria|null
     */
    public function make($model, $method = 'get')
    {
        if (!$model) {
            $model = EloquentModel::class;
        }

        /* @var EloquentModel $model */
        $model = app($model);

        $criteria = $model->getCriteriaName();
        $query    = $model->newQuery();

        return app(
            $criteria,
            [
                'query'  => $query,
                'method' => $method,
            ]
        );
    }
}
