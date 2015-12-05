<?php namespace Anomaly\Streams\Platform\Entry\Plugin;

use Anomaly\Streams\Platform\Entry\EntryCriteria;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class EntryQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Plugin
 */
class EntryQuery
{

    use DispatchesJobs;
    use FiresCallbacks;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new StreamPluginFunctions instance.
     *
     * @param Hydrator  $hydrator
     * @param Container $container
     */
    public function __construct(Hydrator $hydrator, Container $container)
    {
        $this->hydrator  = $hydrator;
        $this->container = $container;
    }

    /**
     * Make a new EntryBuilder instance.
     *
     * @param        $namespace
     * @param        $stream
     * @param string $method
     * @return EntryCriteria
     */
    public function make($namespace, $stream, $method = 'get')
    {
        $stream    = ucfirst(snake_case($stream));
        $namespace = ucfirst(snake_case($namespace));

        /* @var EntryModel $model */
        $model = $this->container->make(
            'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel'
        );

        $criteria = substr(get_class($model), 0, -5) . 'Criteria';

        if (!class_exists($criteria)) {
            $criteria = 'Anomaly\Streams\Platform\Entry\EntryCriteria';
        }

        return $this->container->make(
            $criteria,
            [
                'query'  => $model->newQuery(),
                'stream' => $model->getStream(),
                'method' => $method
            ]
        );
    }
}
