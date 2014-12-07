<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Field\FieldCollection;
use Laracasts\Commander\CommanderTrait;

class SectionFactory
{

    use CommanderTrait;

    protected $sections;

    function __construct(SectionRepository $sections)
    {
        $this->sections = $sections;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['section']) and class_exists($parameters['section'])) {

            return app()->make($parameters['section'], $parameters);
        }

        if ($section = array_get($parameters, 'section') and $section = $this->sections->find($section)) {

            $section = array_replace_recursive($section, array_except($parameters, 'section'));

            return app()->make($section['section'], $section);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Section\Section', $parameters);
    }

    protected function makeFields(array $fields)
    {
        $fieldCollection = new FieldCollection();

        foreach ($fields as $parameters) {

            $field = $this->execute(
                'Anomaly\Streams\Platform\Ui\Form\Field\Command\MakeFieldCommand',
                compact('parameters')
            );
        }

        return $fieldCollection;
    }
}
 