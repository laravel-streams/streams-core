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

            /**
             * If the slug is numeric and the field is a
             * string then use the field the field.
             */
            if (is_numeric($slug) && is_string($field)) {

                $field = [
                    'field' => $field,
                ];
            }

            /**
             * If the slug is not numeric and the field is
             * an array without a slug then use the slug.
             */
            if (!is_numeric($slug) && is_array($field) && !isset($field['slug'])) {

                $field['slug'] = $slug;
            }

            /**
             * If the slug is numeric and the field is
             * an array without a slug but has a field
             * then use the field as the slug as well.
             */
            if (is_numeric($slug) && is_array($field) && !isset($field['slug']) && isset($field['field'])) {

                $field['slug'] = $field['field'];
            }
        }
    }
}
 