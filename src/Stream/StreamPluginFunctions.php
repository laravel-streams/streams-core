<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Model\EloquentCollection;
use Illuminate\Container\Container;

/**
 * Class StreamPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream
 */
class StreamPluginFunctions
{

    /**
     * Protected query builder methods.
     *
     * @var array
     */
    protected $protectedMethods = [
        'update',
        'delete'
    ];

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new StreamPluginFunctions instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Return a collection of stream entries.
     *
     * @param       $namespace
     * @param       $stream
     * @param array $parameters
     * @return EloquentCollection
     */
    public function entries($namespace, $stream, array $parameters = [])
    {
        $stream    = ucfirst(camel_case($stream));
        $namespace = ucfirst(camel_case($namespace));

        $model = $this->container->make(
            'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel'
        );

        foreach ($parameters as $parameter => $arguments) {

            $method = camel_case($parameter);

            if (in_array($method, $this->protectedMethods)) {
                continue;
            }

            $model = call_user_func_array([$model, $method], (array)$arguments);
        }

        return $model->get();
    }
}
