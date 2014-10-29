<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUi;
use Anomaly\Streams\Platform\Ui\Table\TableUtility;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

/**
 * Class BuildTableFiltersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableFiltersCommandHandler
{

    /**
     * The table utility object.
     *
     * @var
     */
    protected $utility;

    /**
     * Create a new BuildTableFiltersCommandHandler instance.
     *
     * @param TableUtility $utility
     */
    function __construct(TableUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param BuildTableFiltersCommand $command
     * @return array
     */
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

            unset($filter['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $this->utility->evaluate($filter, [$ui]);

            // Build out required data.
            $slug   = $this->getSlug($filter);
            $_input = $this->getInput($filter, $slug, $ui); // TODO: Lexicon bug.

            $filter = compact('_input');

            $filters[] = $filter;

        }

        return array_filter($filters);
    }

    /**
     * Get the slug.
     *
     * @param $filter
     * @return mixed|null
     */
    protected function getSlug($filter)
    {
        return evaluate_key($filter, 'slug');
    }

    /**
     * Get the input HTML.
     *
     * @param         $filter
     * @param         $slug
     * @param TableUi $ui
     * @return null
     */
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

    /**
     * Get HTML for a select input.
     *
     * @param         $filter
     * @param         $slug
     * @param TableUi $ui
     * @return mixed
     */
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

    /**
     * Get the HTML for a text input.
     *
     * @param         $filter
     * @param         $type
     * @param         $slug
     * @param TableUi $ui
     * @return mixed
     */
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

    /**
     * Get the HTML for a field input.
     *
     * @param         $filter
     * @param TableUi $ui
     * @return null
     */
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
 