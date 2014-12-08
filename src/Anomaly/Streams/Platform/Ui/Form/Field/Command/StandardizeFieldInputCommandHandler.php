<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Command;

class StandardizeFieldInputCommandHandler
{

    public function handle(StandardizeFieldInputCommand $command)
    {
        $builder = $command->getBuilder();

        $sections = [];

        foreach ($builder->getSections() as $section) {

            if (isset($section['fields'])) {

                $this->standardizeFields($section['fields']);
            }

            $sections[] = $section;
        }

        $builder->setSections($sections);
    }

    protected function standardizeFields(array &$fields)
    {
        foreach ($fields as $slug => &$field) {

            if (is_numeric($slug) and is_string($field)) {

                $field = [
                    'field' => $field,
                ];
            }
        }
    }
}
 