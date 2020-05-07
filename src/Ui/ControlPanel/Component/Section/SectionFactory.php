<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

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
     * Make the section from it's parameters.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        $section = App::make(array_get($parameters, 'section', $this->section), $parameters);

        Hydrator::hydrate($section, $parameters);

        return $section;
    }
}
