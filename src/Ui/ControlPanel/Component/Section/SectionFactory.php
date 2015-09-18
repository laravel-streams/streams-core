<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Support\Hydrator;

/**
 * Class SectionFactory.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section
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
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new SectionFactory instance.
     *
     * @param Hydrator $hydrator
     */
    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * Make the section from it's parameters.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        $section = app()->make(array_get($parameters, 'section', $this->section), $parameters);

        $this->hydrator->hydrate($section, $parameters);

        return $section;
    }
}
