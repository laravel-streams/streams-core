<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Facades\Decorator;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

/**
 * Class FormCriteria
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Create a new FormCriteria instance.
     *
     * @param Repository $cache
     * @param Request $request
     * @param Container $container
     * @param FormBuilder $builder
     * @param array $parameters
     */
    public function __construct(
        Repository $cache,
        Request $request,
        Container $container,
        FormBuilder $builder,
        array $parameters = []
    ) {
        $this->cache      = $cache;
        $this->builder    = $builder;
        $this->request    = $request;
        $this->container  = $container;
        $this->parameters = $parameters;

        $this->setBuilder($builder);

        $this->fire('initialized', ['criteria' => $this]);
    }

    /**
     * Get the form.
     *
     * @return FormPresenter
     */
    public function get()
    {
        $this->build();

        return Decorator::decorate($this->builder->make()->getForm());
    }

    /**
     * Build the builder.
     *
     * @return FormBuilder
     */
    public function build()
    {

        /*
         * Hide breadcrumbs by default.
         */
        array_set(
            $this->parameters,
            'options.breadcrumb',
            array_get(
                $this->parameters,
                'options.breadcrumb',
                false
            )
        );

        /*
         * Cache and hash!
         */
        array_set($this->parameters, 'key', md5(json_encode($this->parameters)));

        /*
         * Set the forms URL after obtaining
         * our parameter hash for the form.
         */
        array_set(
            $this->parameters,
            'options.url',
            array_get(
                $this->parameters,
                'options.url',
                url($this->builder->getOption('url', 'form/handle/' . array_get($this->parameters, 'key')))
            )
        );

        $this->cache->remember(
            'form::' . array_get($this->parameters, 'key'),
            1440,
            function () {
                return $this->parameters;
            }
        );

        if (is_array(array_get($this->parameters, 'options'))) {
            foreach (array_pull($this->parameters, 'options') as $key => $value) {
                $this->builder->setOption($key, $value);
            }
        }

        foreach ($this->parameters as $method => $arguments) {
            if (method_exists($this->builder, $method)) {
                call_user_func([$this->builder, $method], Decorator::undecorate($arguments));
            }
        }

        return Hydrator::hydrate($this->builder, $this->parameters);
    }

    /**
     * Set a parameter.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
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
     * @param  FormBuilder $builder
     * @return $this
     */
    public function setBuilder($builder)
    {
        if (!is_object($builder)) {
            $builder = app($builder);
        }

        $this->builder = $builder;

        if (!isset($this->parameters['builder'])) {
            array_set($this->parameters, 'builder', get_class($this->builder));
        }

        foreach ($this->parameters as $method => $arguments) {
            if (method_exists($this->builder, $method)) {
                call_user_func([$this->builder, $method], Decorator::undecorate($arguments));
            }
        }

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
        if (method_exists($this, $method = camel_case('set_' . $name))) {

            call_user_func([$this, $method], Decorator::undecorate(array_shift($arguments)));

            return $this;
        }

        if (method_exists($this, $method = camel_case('add_' . $name))) {

            call_user_func([$this, $method], Decorator::undecorate(array_shift($arguments)));

            return $this;
        }

        if (method_exists($this->builder, $method = camel_case($name))) {

            array_set($this->parameters, $method, Decorator::undecorate($arguments));

            return $this;
        }

        if (method_exists($this->builder, camel_case('set_' . $name))) {

            array_set($this->parameters, $name, Decorator::undecorate(array_shift($arguments)));

            return $this;
        }

        if (method_exists($this->builder, camel_case('add_' . $name))) {

            array_set($this->parameters, $name, Decorator::undecorate(array_shift($arguments)));

            return $this;
        }

        if (!method_exists($this->builder, camel_case($name)) && count($arguments) === 1) {

            $key = snake_case($name);

            array_set($this->parameters, "options.{$key}", Decorator::undecorate(array_shift($arguments)));

            return $this;
        }

        if (!method_exists($this->builder, camel_case($name)) && count($arguments) === 0) {

            $key = snake_case($name);

            // Helpful for form.disableLabels().disableFoo() ...
            array_set($this->parameters, "options.{$key}", true);

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
