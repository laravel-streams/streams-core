<?php namespace Anomaly\Streams\Platform\Addon\Plugin;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

/**
 * Class PluginForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Plugin
 */
class PluginForm
{

    /**
     * The cache repository.
     *
     * @var Repository
     */
    protected $cache;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * The object hydrator.
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
     * Create a new PluginForm instance.
     *
     * @param Repository $cache
     * @param Request    $request
     * @param Hydrator   $hydrator
     * @param Container  $container
     */
    public function __construct(Repository $cache, Request $request, Hydrator $hydrator, Container $container)
    {
        $this->cache     = $cache;
        $this->request   = $request;
        $this->hydrator  = $hydrator;
        $this->container = $container;
    }

    /**
     * Build the form.
     *
     * @param array $parameters
     * @return FormBuilder
     */
    public function build(array $parameters = [])
    {
        return $this->resolve($parameters)->build();
    }

    /**
     * Make the form.
     *
     * @param array $parameters
     * @return FormBuilder
     */
    public function make(array $parameters = [])
    {
        return $this->resolve($parameters)->make();
    }

    /**
     * Render the form.
     *
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render(array $parameters = [])
    {
        return $this->resolve($parameters)->render();
    }

    /**
     * Resolve the builder instance
     * from the parameters.
     *
     * @param array $parameters
     * @return FormBuilder
     */
    public function resolve(array $parameters = [])
    {
        $parameters = $cache = $this->setDefaults($parameters);

        $parameters['key'] = md5(json_encode($parameters));

        /* @var FormBuilder $builder */
        $builder = $this->container->make(array_get($parameters, 'builder'));

        // Merge options if not a handler.
        if (is_array($options = $builder->getOptions())) {
            $builder->setOptions(array_replace_recursive($options, array_pull($parameters, 'options', [])));
        }

        // Hydrate the builder.
        $this->hydrator->hydrate($builder, $parameters);

        // Use the core form handler if none set.
        if (!$builder->getFormOption('url')) {
            $builder->setFormOption('url', 'form/handle/' . $parameters['key']);
        }

        // Use the current page if no redirect.
        if (!$builder->getFormOption('redirect')) {
            $builder->setFormOption('redirect', $this->request->fullUrl());
        }

        $this->cache->forever('form::' . $parameters['key'], $cache);

        return $builder;
    }

    /**
     * Set the default parameters.
     *
     * @param array $parameters
     * @return array
     */
    protected function setDefaults(array $parameters)
    {

        /**
         * Set the default builder and model based
         * a stream and namespace parameter provided.
         */
        if (!$builder = array_get($parameters, 'builder')) {
            if (!$model = array_get($parameters, 'model')) {

                $stream    = ucfirst(camel_case(array_get($parameters, 'stream')));
                $namespace = ucfirst(camel_case(array_get($parameters, 'namespace')));

                $model = 'Anomaly\Streams\Platform\Model\\' . $namespace . '\\' . $namespace . $stream . 'EntryModel';

                array_set($parameters, 'model', $model);
            }

            array_set($parameters, 'builder', 'Anomaly\Streams\Platform\Ui\Form\FormBuilder');
        }

        /**
         * Set some default options.
         */
        array_set(
            $parameters,
            'options.panel_class',
            array_get($parameters, 'options.panel_class', 'section')
        );
        array_set(
            $parameters,
            'options.panel_body_class',
            array_get($parameters, 'options.panel_body_class', 'section-body')
        );
        array_set(
            $parameters,
            'options.panel_title_class',
            array_get($parameters, 'options.panel_title_class', 'section-title')
        );
        array_set(
            $parameters,
            'options.panel_heading_class',
            array_get($parameters, 'options.panel_heading_class', 'section-heading')
        );

        return $parameters;
    }
}
