<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Support\Hydrator;
use Illuminate\Contracts\Container\Container;

/**
 * Class SectionFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionFactory
{

    /**
     * The default section class.
     *
     * @var string
     */
    protected $section = Section::class;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new SectionFactory instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make the section from it's parameters.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        $section = $this->container->make(array_get($parameters, 'section', $this->section), $parameters);

        Hydrator::hydrate($section, $parameters);

        return $section;
    }
}
