<?php namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Robbo\Presenter\Decorator;

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
     * These are methods that are
     * protected and may not be
     * accessed during plugin use.
     *
     * @var array
     */
    protected $protectedMethods = [
        'update',
        'delete'
    ];

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
     * The presenter decorator.
     *
     * @var Decorator
     */
    protected $decorator;

    /**
     * Create a new StreamPluginFunctions instance.
     *
     * @param Hydrator  $hydrator
     * @param Container $container
     * @param Decorator $decorator
     */
    public function __construct(Hydrator $hydrator, Container $container, Decorator $decorator)
    {
        $this->hydrator  = $hydrator;
        $this->container = $container;
        $this->decorator = $decorator;
    }

    /**
     * Return a collection of stream entries.
     *
     * @param array $parameters
     * @return EntryCollection
     */
    public function entries(array $parameters = [])
    {
        if (!$model = array_get($parameters, 'model')) {

            $stream    = ucfirst(camel_case(array_get($parameters, 'stream')));
            $namespace = ucfirst(camel_case(array_get($parameters, 'namespace')));

            $model = 'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel';
        }

        /* @var EntryModel|Builder $model */
        $model = $this->container->make($model);

        foreach ($parameters as $parameter => $arguments) {

            $method = camel_case($parameter);

            if (in_array($method, $this->protectedMethods)) {
                continue;
            }

            $model = call_user_func([$model, $method], $arguments);
        }

        return $this->decorator->decorate($model->get());
    }

    /**
     * Return a single stream entry.
     *
     * @param array $parameters
     * @return EntryPresenter
     */
    public function entry(array $parameters = [])
    {
        if (!$model = array_get($parameters, 'model')) {

            $stream    = ucfirst(camel_case(array_get($parameters, 'stream')));
            $namespace = ucfirst(camel_case(array_get($parameters, 'namespace')));

            $model = 'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel';
        }

        /* @var EntryModel|Builder $model */
        $model = $this->container->make($model);

        foreach ($parameters as $parameter => $arguments) {

            $method = camel_case($parameter);

            if (in_array($method, $this->protectedMethods)) {
                continue;
            }

            $model = call_user_func([$model, $method], $arguments);
        }

        return $this->decorator->decorate($model->first());
    }

    /**
     * Return a stream entry form.
     *
     * @param array $parameters
     * @return $this
     */
    public function form(array $parameters = [])
    {
        if (!$builder = array_get($parameters, 'builder')) {

            if (!$model = array_get($parameters, 'model')) {

                $stream    = ucfirst(camel_case(array_get($parameters, 'stream')));
                $namespace = ucfirst(camel_case(array_get($parameters, 'namespace')));

                $model = 'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel';

                array_set($parameters, 'model', $model);
            }

            $builder = 'Anomaly\Streams\Platform\Ui\Form\FormBuilder';
        }

        /* @var FormBuilder $builder */
        $builder = $this->container->make($builder);

        $this->hydrator->hydrate($builder, $parameters);

        $builder->make();

        return $builder->getForm();
    }
}
