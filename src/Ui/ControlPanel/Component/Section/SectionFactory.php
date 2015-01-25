<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;

/**
 * Class SectionFactory
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
    protected $section = 'Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Section';

    /**
     * Make the section from it's parameters.
     *
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        $section = app()->make(array_get($parameters, 'section', $this->section), $parameters);

        $this->hydrate($section, $parameters);

        return $section;
    }

    /**
     * Hydrate the section with it's remaining parameters.
     *
     * @param SectionInterface $section
     * @param array            $parameters
     */
    protected function hydrate(SectionInterface $section, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($section, $method)) {
                $section->{$method}($value);
            }
        }
    }
}
