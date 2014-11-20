<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TablePresets;

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
     * @var \Anomaly\Streams\Platform\Ui\Table\TablePresets
     */
    protected $utility;

    /**
     * Create a new BuildTableFiltersCommandHandler instance.
     *
     * @param TablePresets $utility
     */
    function __construct(TablePresets $utility)
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
        $table = $command->getTable();

        $filters = [];

        foreach ($table->getFilters() as $slug => $filter) {

            // Standardize input.
            $filter = $this->standardize($slug, $filter);

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($filter['handler']);

            // Evaluate everything in the array.
            // All closures are gone now.
            $this->utility->evaluate($filter, [$table]);

            // Skip if disabled.
            if (!evaluate_key($filter, 'enabled', true)) {

                continue;
            }

            // Build out required data.
            $input = $this->getInput($filter, $table);

            $filter = compact('input');

            $filters[] = $filter;
        }

        return array_filter($filters);
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $slug
     * @param $filter
     * @return array
     */
    protected function standardize($slug, $filter)
    {

        /**
         * If the slug is numerical and the view
         * is a string then use view for both.
         */
        if (is_numeric($slug) and is_string($filter)) {

            return [
                'type'  => 'field',
                'field' => $filter,
                'slug'  => $filter,
            ];
        }

        /**
         * If the slug is a string and the view
         * is too then use the slug as slug and
         * the view as the type.
         */
        if (is_string($filter)) {

            return [
                'type'  => 'field',
                'field' => $filter,
                'slug'  => $slug,
            ];
        }

        /**
         * If the slug is not explicitly set
         * then default it to the slug inferred.
         */
        if (is_array($filter) and !isset($filter['slug'])) {

            $filter['slug'] = $slug;
        }

        return $filter;
    }

    /**
     * Get the slug.
     *
     * @param array $filter
     * @param Table $table
     * @return string
     */
    protected function getSlug(array $filter, Table $table)
    {
        return $table->getPrefix() . $filter['slug'];
    }

    /**
     * Get the input HTML.
     *
     * @param array $filter
     * @param Table $table
     * @return mixed|null
     */
    protected function getInput(array $filter, Table $table)
    {
        $type = evaluate_key($filter, 'type', 'text', [$table]);

        switch ($type) {

            // Build a generic select filter input.
            case 'select':
                return $this->getSelectInput($filter, $table);
                break;

            // Build a generic type style filter input.
            case 'url':
            case 'text':
            case 'email':
            case 'password':
                return $this->getTextInput($filter, $type, $table);
                break;

            // Build a field type filter input.
            case 'field':
                return $this->getInputFromField($filter, $table, $table->getModel());
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Get HTML for a select input.
     *
     * @param array $filter
     * @param Table $table
     * @return mixed
     */
    protected function getSelectInput(array $filter, Table $table)
    {
        $form = app('form');

        $slug  = $this->getSlug($filter, $table);
        $value = $this->getValue($filter, $table);

        $options = evaluate_key($filter, 'options', [], [$table]);

        $attributes = [
            'class' => 'form-control',
        ];

        return $form->select($slug, $options, $value, $attributes);
    }

    /**
     * Get the HTML for a text input.
     *
     * @param array  $filter
     * @param string $type
     * @param Table  $table
     * @return mixed
     */
    protected function getTextInput(array $filter, $type, Table $table)
    {
        $form = app('form');

        $slug  = $this->getSlug($filter, $table);
        $value = $this->getValue($filter, $table);

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
     * @param array $filter
     * @param Table $table
     * @return null
     */
    protected function getInputFromField(array $filter, Table $table, EntryInterface $model)
    {
        $assignment = $model->getAssignmentFromField($filter['field']);

        if ($assignment instanceof AssignmentModel) {

            return $this->getFieldInputFromAssignment($filter, $table, $assignment);
        }

        return null;
    }

    /**
     * Get the field input from an assignment.
     *
     * @param array           $filter
     * @param Table           $table
     * @param AssignmentModel $assignment
     * @return null
     */
    protected function getFieldInputFromAssignment(array $filter, Table $table, AssignmentModel $assignment)
    {
        $fieldType = $assignment->type();

        $prefix = $this->getPrefix($table);

        $placeholder = evaluate_key($filter, 'placeholder');

        if ($fieldType instanceof FieldType) {

            // Load the field type with some options.
            $fieldType->setPrefix($prefix);
            $fieldType->setValue($this->getValue($filter, $table));
            $fieldType->setPlaceholder($placeholder ? : trans($assignment->field->name));

            return $fieldType->renderFilter();
        }

        return null;
    }

    /**
     * Get the filter's value.
     *
     * @param array $filter
     * @param Table $table
     * @return mixed
     */
    protected function getValue(array $filter, Table $table)
    {
        $prefix = $this->getPrefix($table);

        return app('request')->get($prefix . $filter['slug']);
    }

    /**
     * Get the prefix.
     *
     * @param Table $table
     * @return string
     */
    protected function getPrefix(Table $table)
    {
        return $table->getPrefix() . 'filter_';
    }
}
 