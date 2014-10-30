<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableUtility;

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
     * @param $command
     * @return array
     */
    public function handle($command)
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
            $input = $this->getInput($filter, $ui);

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
     * @return array
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
                'slug'  => $filter,
            ];

        }

        return $filter;
    }

    /**
     * Get the input HTML.
     *
     * @param $filter
     * @param $ui
     * @return mixed|null
     */
    protected function getInput($filter, $ui)
    {
        $type = evaluate_key($filter, 'type', 'text', [$ui]);

        switch ($type) {

            /**
             * Build a generic select filter input.
             */
            case 'select':
                return $this->getSelectInput($filter, $ui);
                break;

            /**
             * Build a generic type style filter input.
             */
            case 'url':
            case 'text':
            case 'email':
            case 'password':
                return $this->getTextInput($filter, $type, $ui);
                break;

            /**
             * Build a field type filter input.
             */
            case 'field':
                return $this->getInputFromField($filter, $ui);
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
     * @param $filter
     * @param $ui
     * @return mixed
     */
    protected function getSelectInput($filter, $ui)
    {
        $form = app('form');

        $slug  = $this->getSlug($filter, $ui);
        $value = $this->getValue($filter, $ui);

        $options = evaluate_key($filter, 'options', [], [$ui]);

        $attributes = [
            'class' => 'form-control',
        ];

        return $form->select($slug, $options, $value, $attributes);
    }

    /**
     * Get the HTML for a text input.
     *
     * @param $filter
     * @param $type
     * @param $ui
     * @return mixed
     */
    protected function getTextInput($filter, $type, $ui)
    {
        $form = app('form');

        $slug  = $this->getSlug($filter, $ui);
        $value = $this->getValue($filter, $ui);

        $placeholder = evaluate_key($filter, 'placeholder');

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return $form->{$type}($slug, $value, $options);
    }

    /**
     * Get the HTML for a field input.
     *
     * @param $filter
     * @param $ui
     * @return null
     */
    protected function getInputFromField($filter, $ui)
    {
        $entryModel = $ui->getModel();

        $assignment = $entryModel->findAssignmentByFieldSlug($filter['field']);

        if ($assignment) {

            return $this->getFieldInputFromAssignment($assignment, $filter, $ui);

        }

        return null;
    }

    /**
     * Get the field input from an assignment.
     *
     * @param $assignment
     * @param $filter
     * @param $ui
     * @return null
     */
    protected function getFieldInputFromAssignment($assignment, $filter, $ui)
    {
        $fieldType = $assignment->type();

        $prefix = $this->getPrefix($ui);

        $placeholder = evaluate_key($filter, 'placeholder');

        if ($fieldType) {

            $value = $this->getValue($filter, $ui);

            // Load the field type with some options.
            $fieldType->setValue($value);
            $fieldType->setPrefix($prefix);
            $fieldType->setPlaceholder($placeholder ? : trans($assignment->field->name));

            return $fieldType->filter();

        }

        return null;
    }

    /**
     * Get the filter's value.
     *
     * @param $filter
     * @param $ui
     * @return mixed
     */
    protected function getValue($filter, $ui)
    {
        $prefix = $this->getPrefix($ui);

        return app('request')->get($prefix . $filter['slug']);
    }

    /**
     * Get the slug.
     *
     * @param $filter
     * @param $ui
     * @return string
     */
    protected function getSlug($filter, $ui)
    {
        return $this->getPrefix($ui) . $filter['slug'];
    }

    /**
     * Get the prefix.
     *
     * @param $ui
     * @return string
     */
    protected function getPrefix($ui)
    {
        return $ui->getPrefix() . 'filter_';
    }

}
 