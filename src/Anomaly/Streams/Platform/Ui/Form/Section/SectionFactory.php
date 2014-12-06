<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

class SectionFactory
{

    protected $sections;

    function __construct(SectionRepository $sections)
    {
        $this->sections = $sections;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['section']) and class_exists($parameters['section'])) {

            $this->makeLayout($parameters);

            return app()->make($parameters['section'], $parameters);
        }

        if ($section = array_get($parameters, 'section') and $section = $this->sections->find($section)) {

            $section = array_replace_recursive($section, array_except($parameters, 'section'));

            $this->makeLayout($section);

            return app()->make($section['section'], $section);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Section\Section', $parameters);
    }

    protected function makeLayout(array &$section)
    {
        if (isset($section['layout'])) {

            if (is_string($section['layout'])) {

                $section['layout'] = ['html' => $section['layout']];
            }

            $section['layout'] = $this->layoutFactory->make($section['layout']);
        }
    }
}
 