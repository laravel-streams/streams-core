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
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUtility
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

            // Standardize input.
            $filter = $this->standardize($filter);

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($filter['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $this->utility->evaluate($filter, [$ui]);

            // Build out required data.
            $slug  = $this->getSlug($filter, $ui);
            $input = $this->getInput($filter, $slug, $ui);

            $filter = compact('input');

            $filters[] = $filter;

        }

        return array_filter($filters);
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $filter
     */
    protected function standardize($filter)
    {
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

        return $filter;
    }

    /**
     * Get the slug.
     *
     * @param array   $filter
     * @param TableUi $ui
     * @return string
     */
    protected function getSlug(array $filter, TableUi $ui)
    {
        return $ui->getPrefix() . $filter['slug'];
    }

    /**
     * Get the input HTML.
     *
     * @param array   $filter
     * @param         $slug
     * @param TableUi $ui
     * @return mixed|null
     */
    protected function getInput(array $filter, $slug, TableUi $ui)
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
     * @param array   $filter
     * @param         $slug
     * @param TableUi $ui
     * @return mixed
     */
    protected function getSelectInput(array $filter, $slug, TableUi $ui)
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
     * @param array   $filter
     * @param         $type
     * @param         $slug
     * @param TableUi $ui
     * @return mixed
     */
    protected function getTextInput(array $filter, $type, $slug, TableUi $ui)
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
     * @param array   $filter
     * @param TableUi $ui
     * @return null
     */
    protected function getFieldInput(array $filter, TableUi $ui)
    {
        $assignment = $ui->getModel()->getStream()->assignments->findByFieldSlug($filter['field']);

        if ($assignment instanceof AssignmentModel) {

            return $this->getFieldInputFromAssignment($assignment);

        }

        return null;
    }

    /**
     * Get the field input from an assignment.
     *
     * @param AssignmentModel $assignment
     * @return null
     */
    protected function getFieldInputFromAssignment(AssignmentModel $assignment)
    {
        $fieldType = $assignment->type();

        if ($fieldType instanceof FieldTypeAddon) {

            $fieldType->setPlaceholder(trans($assignment->field->name));

            return $fieldType->filter();

        }

        return null;
    }

}
 