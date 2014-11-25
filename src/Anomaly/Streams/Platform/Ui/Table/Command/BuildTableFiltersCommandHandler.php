<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Ui\Table\Table;

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
     * Handle the command.
     *
     * @param BuildTableFiltersCommand $command
     * @return array
     */
    public function handle(BuildTableFiltersCommand $command)
    {
        $filters = [];

        $table = $command->getTable();

        $expander  = $table->getExpander();
        $evaluator = $table->getEvaluator();

        /**
         * Loop through and process filter configurations.
         */
        foreach ($table->getFilters() as $slug => $filter) {

            // Expand minimal input.
            $filter = $expander->expand($slug, $filter);

            // Automate type / field if possible.
            $filter = $this->automateType($filter, $table);

            /**
             * Remove the handler or it
             * might fire in evaluation.
             */
            unset($filter['handler']);

            // Evaluate the entire filter.
            $evaluator->evaluate($filter, compact('table'));

            // Skip if disabled.
            if (array_get($filter, 'enabled') === false) {

                continue;
            }

            // Build out required data.
            $input = $this->getFilterInput($filter, $table);

            $filters[] = compact('input');
        }

        return array_filter($filters);
    }


    /**
     * Get the input HTML.
     *
     * @param array $filter
     * @param Table $table
     * @return mixed|null
     */
    protected function getFilterInput(array $filter, Table $table)
    {
        $type = array_get($filter, 'type', 'text');

        switch ($type) {

            // Build a generic select filter input.
            case 'select':
                return $this->buildSelectInput($filter, $table);
                break;

            // Build a generic type style filter input.
            case 'url':
            case 'text':
            case 'email':
            case 'password':
                return $this->buildTextInput($filter, $table, $type);
                break;

            // Build a field type filter input.
            case 'field':
                return $this->buildFieldInput($filter, $table);
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Return the HTML for a generic select input.
     *
     * @param array $filter
     * @param Table $table
     * @return string
     */
    protected function buildSelectInput(array $filter, Table $table)
    {
        $name  = $this->getName($filter, $table);
        $value = $this->getValue($filter, $table);

        $options = evaluate_key($filter, 'options', [], [$table]);

        $attributes = [
            'class' => 'form-control',
        ];

        return app('form')->select($name, $options, $value, $attributes);
    }

    /**
     * Get the HTML for a text input.
     *
     * @param array  $filter
     * @param Table  $table
     * @param string $type
     * @return string
     */
    protected function buildTextInput(array $filter, Table $table, $type)
    {
        $name  = $this->getName($filter, $table);
        $value = $this->getValue($filter, $table);

        $placeholder = evaluate_key($filter, 'placeholder');

        $options = [
            'class'       => 'form-control',
            'placeholder' => $placeholder,
        ];

        return app('form')->{$type}($name, $value, $options);
    }

    /**
     * Get the HTML for a field type filter input.
     *
     * @param array $filter
     * @param Table $table
     * @return null
     */
    protected function buildFieldInput(array $filter, Table $table)
    {
        $stream = $table->getStream();
        $field  = $stream->getField($filter['field']);

        $type = $field->getType();

        $type->setPlaceholder(trans($field->getName()));

        return $type->renderFilter();
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

    /**
     * Get the name.
     *
     * @param array $filter
     * @param Table $table
     * @return string
     */
    protected function getName(array $filter, Table $table)
    {
        return $table->getPrefix() . 'filter_' . $filter['slug'];
    }

    /**
     * Set the field to the slug if the slug is a valid field.
     *
     * @param array $filter
     * @param Table $table
     */
    protected function automateType(array $filter, Table $table)
    {
        if ($stream = $table->getStream()) {

            if (!isset($filter['field']) and $field = $stream->getField($filter['slug'])) {

                $filter['type']  = 'field';
                $filter['field'] = $filter['slug'];
            }
        }

        return $filter;
    }
}
 