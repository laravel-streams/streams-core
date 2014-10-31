<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableUi;
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

            // If not enabled then skip it.
            if (!evaluate_key($filter, 'enabled', true)) {

                continue;
            }

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
     * @param TableUi $ui
     * @return mixed|null
     */
    protected function getInput(array $filter, TableUi $ui)
    {
        $type = evaluate_key($filter, 'type', 'text', [$ui]);

        switch ($type) {

            // Build a generic select filter input.
            case 'select':
                return $this->getSelectInput($filter, $ui);
                break;

            // Build a generic type style filter input.
            case 'url':
            case 'text':
            case 'email':
            case 'password':
                return $this->getTextInput($filter, $type, $ui);
                break;

            // Build a field type filter input.
            case 'field':
                return $this->getInputFromField($filter, $ui, $ui->getModel());
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Get HTML for a select input.
     *
     * @param array   $filter
     * @param TableUi $ui
     * @return mixed
     */
    protected function getSelectInput(array $filter, TableUi $ui)
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
     * @param array   $filter
     * @param string  $type
     * @param TableUi $ui
     * @return mixed
     */
    protected function getTextInput(array $filter, $type, TableUi $ui)
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
     * @param array   $filter
     * @param TableUi $ui
     * @return null
     */
    protected function getInputFromField(array $filter, TableUi $ui, EntryInterface $model)
    {
        $assignment = $model->getAssignmentFromField($filter['field']);

        if ($assignment instanceof AssignmentModel) {

            return $this->getFieldInputFromAssignment($filter, $ui, $assignment);
        }

        return null;
    }

    /**
     * Get the field input from an assignment.
     *
     * @param array           $filter
     * @param TableUi         $ui
     * @param AssignmentModel $assignment
     * @return null
     */
    protected function getFieldInputFromAssignment(array $filter, TableUi $ui, AssignmentModel $assignment)
    {
        $fieldType = $assignment->type();

        $prefix = $this->getPrefix($ui);

        $placeholder = evaluate_key($filter, 'placeholder');

        if ($fieldType instanceof FieldTypeAddon) {

            // Load the field type with some options.
            $fieldType->setPrefix($prefix);
            $fieldType->setValue($this->getValue($filter, $ui));
            $fieldType->setPlaceholder($placeholder ? : trans($assignment->field->name));

            return $fieldType->filter();
        }

        return null;
    }

    /**
     * Get the filter's value.
     *
     * @param array   $filter
     * @param TableUi $ui
     * @return mixed
     */
    protected function getValue(array $filter, TableUi $ui)
    {
        $prefix = $this->getPrefix($ui);

        return app('request')->get($prefix . $filter['slug']);
    }

    /**
     * Get the prefix.
     *
     * @param TableUi $ui
     * @return string
     */
    protected function getPrefix(TableUi $ui)
    {
        return $ui->getPrefix() . 'filter_';
    }
}
 