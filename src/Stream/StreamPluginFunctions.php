<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
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
     * @param       $stream
     * @param       $namespace
     * @param array $parameters
     * @return EloquentCollection
     */
    public function entries($stream, $namespace, array $parameters = [])
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

            $model = call_user_func([$model, $method], $arguments);
        }

        return $model->get();
    }

    /**
     * Return a single stream entry.
     *
     * @param       $stream
     * @param       $namespace
     * @param array $parameters
     * @return EntryInterface
     */
    public function entry($stream, $namespace, array $parameters = [])
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

            $model = call_user_func([$model, $method], $arguments);
        }

        return $model->first();
    }

    /**
     * Return an entry form.
     *
     * @param       $stream
     * @param       $namespace
     * @param array $parameters
     * @return $this
     */
    public function form($stream, $namespace, array $parameters = [])
    {
        $stream    = ucfirst(camel_case($stream));
        $namespace = ucfirst(camel_case($namespace));

        $model = $this->container->make(
            'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel'
        );

        /* @var FormBuilder $form */
        $form = $this->container->make('Anomaly\Streams\Platform\Ui\Form\FormBuilder');

        $form->setModel($model);

        return $form->make(array_get($parameters, 'entry'));
    }
}
