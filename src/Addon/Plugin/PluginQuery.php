<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryPresenter;
use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Robbo\Presenter\Decorator;

/**
 * Class PluginQuery
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin
 */
class PluginQuery
{

    use FiresCallbacks;

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
     * Return a collection of results.
     *
     * @param array $parameters
     * @return EntryCollection
     */
    public function get(array $parameters)
    {
        return $this->decorator->decorate($this->build($parameters)->get());
    }

    /**
     * Return a result.
     *
     * @param array $parameters
     * @return EntryPresenter
     */
    public function first(array $parameters)
    {
        return $this->decorator->decorate($this->build($parameters)->first());
    }

    /**
     * Build a query.
     *
     * @param array  $parameters
     * @param string $fetch
     * @return array|Builder
     */
    protected function build(array $parameters)
    {

        /**
         * Determine the model by either using
         * the passed model class string OR
         * building one with namespace / stream.
         */
        if (!$model = array_pull($parameters, 'model')) {

            $stream    = ucfirst(camel_case(array_pull($parameters, 'stream')));
            $namespace = ucfirst(camel_case(array_pull($parameters, 'namespace')));

            $model = 'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel';
        }

        /* @var EntryModel $model */
        $model = $this->container->make($model);

        /* @var Builder $query */
        $query = $model->newQuery();

        $this->fire('querying', compact('query', 'model', 'parameters'));

        /**
         * First apply any desired scope.
         */
        if ($scope = array_pull($parameters, 'scope')) {
            call_user_func([$query, camel_case($scope)], array_pull($parameters, 'scope_arguments', []));
        }

        /**
         * Lastly we need to loop through all of the
         * parameters and assume the rest are methods
         * to call on the query builder.
         */
        foreach ($parameters as $method => $arguments) {

            $method = camel_case($method);

            if (in_array($method, $this->protectedMethods)) {
                continue;
            }

            call_user_func([$query, $method], $arguments);
        }

        return $query;
    }
}
