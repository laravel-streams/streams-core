<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Ui\Table\TableUi;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

class BuildTableFiltersCommandHandler
{
    public function handle(BuildTableFiltersCommand $command)
    {
        $ui = $command->getUi();

        $filters = [];

        foreach ($ui->getFilters() as $filter) {

            /**
             * If the filter is a string then
             * default to a field type with the
             * string being the field slug.
             */
            if (is_string($filter)) {

                $filter = [
                    'type'  => 'field',
                    'field' => $filter,
                ];

            }

            // Evaluate everything in the array.
            // All closures are gone now.
            $this->evaluate($filter, $ui);

            // Build out required data.
            $slug   = $this->getSlug($filter);
            $_input = $this->getInput($filter, $slug, $ui); // TODO: Lexicon bug.

            $filter = compact('_input');

            $filters[] = $filter;

        }

        return array_filter($filters);
    }

    protected function evaluate($filter, TableUi $ui)
    {
        return evaluate($filter, [$ui]);
    }

    protected function getSlug($filter)
    {
        return 'f-' . slugify(evaluate_key($filter, 'slug', hashify($filter)), '-');
    }

    protected function getInput($filter, $slug, TableUi $ui)
    {
        $type = evaluate_key($filter, 'type', 'text', [$ui]);

        switch ($type) {

            /**
             * Build a generic select filter input.
             */
            case 'select':
                return $this->getSelectInput($filter, $slug, $ui);
                break;

            /**
             * Build a generic type style filter input.
             */
            case 'url':
            case 'text':
            case 'email':
            case 'password':
                return $this->getTextInput($filter, $type, $slug, $ui);
                break;

            /**
             * Build a field type filter input.
             */
            case 'field':
                return $this->getFieldInput($filter, $ui);
                break;

            /**
             * Don't do shit by default.
             */
            default:
                return null;
                break;
        }
    }

    protected function getSelectInput($filter, $slug, TableUi $ui)
    {
        $form    = app('form');
        $request = app('request');

        $options = evaluate_key($filter, 'options', [], [$ui]);

        $value = $request->get($slug);

        $attributes = [
            'class' => 'form-control',
        ];

        return $form->select($slug, $options, $value, $attributes);
    }

    protected function getTextInput($filter, $type, $slug, TableUi $ui)
    {
        $form    = app('form');
        $request = app('request');

        $placeholder = evaluate_key($filter, 'placeholder', null, [$ui]);

        $value = $request->get($slug);

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->{$type}($slug, $value, $options);
    }

    protected function getFieldInput($filter, TableUi $ui)
    {
        $assignment = $ui->getModel()->getStream()->assignments->findByFieldSlug($filter['field']);

        if ($assignment instanceof AssignmentModel) {

            $fieldType = $assignment->type();

            if ($fieldType instanceof FieldTypeAddon) {

                $fieldType->setPlaceholder(trans($assignment->field->name));

                return $fieldType->filter();

            }

        }

        return null;
    }

}
 