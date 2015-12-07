<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\Support\Hydrator;
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
    }

    /**
     * Get the form.
     *
     * @return FormPresenter
     */
    public function get()
    {
        $this->setDefaults();

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
     * Set the default parameters.
     */
    protected function setDefaults()
    {
        array_set(
            $this->parameters,
            'builder',
            get_class($this->builder)
        );

        array_set(
            $this->parameters,
            'options.redirect',
            array_get(
                $this->parameters,
                'options.redirect',
                $this->builder->getOption('redirect', $this->request->fullUrl())
            )
        );

        array_set(
            $this->parameters,
            'options.panel_class',
            array_get($this->parameters, 'options.panel_class', $this->builder->getOption('panel_class', ''))
        );

        array_set(
            $this->parameters,
            'options.panel_body_class',
            array_get($this->parameters, 'options.panel_body_class', $this->builder->getOption('panel_body_class', ''))
        );

        array_set(
            $this->parameters,
            'options.panel_title_class',
            array_get(
                $this->parameters,
                'options.panel_title_class',
                $this->builder->getOption('panel_title_class', '')
            )
        );

        array_set(
            $this->parameters,
            'options.panel_heading_class',
            array_get(
                $this->parameters,
                'options.panel_heading_class',
                $this->builder->getOption('panel_heading_class', '')
            )
        );
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
