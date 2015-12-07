<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;

/**
 * Class FormCriteria
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormCriteria
{

    use FiresCallbacks;

    /**
     * The cache repository.
     *
     * @var Repository
     */
    protected $cache;

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * The parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Create a new FormCriteria instance.
     *
     * @param Repository  $cache
     * @param Request     $request
     * @param Hydrator    $hydrator
     * @param FormBuilder $builder
     * @param array       $parameters
     */
    public function __construct(
        Repository $cache,
        Request $request,
        Hydrator $hydrator,
        FormBuilder $builder,
        array $parameters = []
    ) {
        $this->cache      = $cache;
        $this->builder    = $builder;
        $this->request    = $request;
        $this->hydrator   = $hydrator;
        $this->parameters = $parameters;

        $this->setBuilder($builder);
    }

    /**
     * Get the form.
     *
     * @return FormPresenter
     */
    public function get()
    {
        $this->fire('ready', ['criteria' => $this]);

        array_set($this->parameters, 'key', md5(json_encode($this->parameters)));

        array_set(
            $this->parameters,
            'options.url',
            array_get(
                $this->parameters,
                'options.url',
                $this->builder->getOption('url', 'form/handle/' . array_get($this->parameters, 'key'))
            )
        );

        $this->cache->remember(
            'form::' . array_get($this->parameters, 'key'),
            30,
            function () {
                return $this->parameters;
            }
        );

        $this->hydrator->hydrate($this->builder, $this->parameters);

        return (new Decorator())->decorate($this->builder->make()->getForm());
    }

    /**
     * Return the hydrated builder.
     *
     * @return FormBuilder
     */
    public function builder()
    {
        $this->hydrator->hydrate($this->builder, $this->parameters);

        return $this->builder;
    }

    /**
     * Get the builder.
     *
     * @return FormBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Set the form builder.
     *
     * @param FormBuilder $builder
     * @return $this
     */
    protected function setBuilder(FormBuilder $builder)
    {
        array_set($this->parameters, 'builder', get_class($builder));

        array_set(
            $this->parameters,
            'options',
            array_merge(
                $builder->getOptions(),
                array_get($this->parameters, 'options', [])
            )
        );

        return $this;
    }

    /**
     * Route through __get
     *
     * @param $name
     * @return $this
     */
    public function __get($name)
    {
        return $this->__call($name, []);
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {

        if (method_exists($this->builder, camel_case('set_' . $name))) {

            array_set($this->parameters, $name, $arguments);

            return $this;
        }

        if (method_exists($this->builder, camel_case('add_' . $name))) {

            array_set($this->parameters, $name, $arguments);

            return $this;
        }

        if (!method_exists($this->builder, camel_case($name)) && count($arguments) === 1) {

            array_set($this->parameters, "options.{$name}", array_shift($arguments));

            return $this;
        }

        return $this;
    }

    /**
     * Return the form.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->get()->__toString();
    }
}
