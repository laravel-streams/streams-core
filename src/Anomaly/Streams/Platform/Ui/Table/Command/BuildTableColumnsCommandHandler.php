<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableColumnsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableColumnsCommandHandler
{

    /**
     * These are not attributes and should
     * not make it to the attribute string.
     *
     * @var array
     */
    protected $notAttributes = [
        'slug',
        'value',
        'field',
        'class',
        'heading',
        'handler',
        'relation',
    ];

    /**
     * Handle the command.
     *
     * @param BuildTableColumnsCommand $command
     * @return array
     */
    public function handle(BuildTableColumnsCommand $command)
    {
        $columns = [];

        $table = $command->getTable();
        $entry = $command->getEntry();

        $expander   = $table->getExpander();
        $evaluator  = $table->getEvaluator();
        $normalizer = $table->getNormalizer();

        foreach ($table->getColumns() as $slug => $column) {

            // Expand minimal input.
            $column = $expander->expand($slug, $column);

            // Evaluate the entire column.
            $column = $evaluator->evaluate($column, compact('table', 'entry'), $entry);

            // Automate some stuff.
            $this->guessField($column, $table);

            // Build out our required data.
            $class      = $this->getClass($column);
            $attributes = $this->getAttributes($column);

            $value = $this->getValue($column, $entry);

            $column = compact('value', 'class', 'attributes');

            // Normalize the result.
            $column = $normalizer->normalize($column);

            $columns[] = $column;
        }

        return $columns;
    }

    /**
     * Get the class.
     *
     * @param array $column
     * @return mixed|null
     */
    protected function getClass(array $column)
    {
        return array_get($column, 'class');
    }

    /**
     * Get the attributes less the keys that are
     * defined as NOT attributes.
     *
     * @param array $column
     * @return array
     */
    protected function getAttributes(array $column)
    {
        return array_diff_key($column, array_flip($this->notAttributes));
    }

    /**
     * Get the value.
     *
     * @param array $column
     * @param mixed $entry
     * @return string
     */
    protected function getValue(array $column, $entry)
    {
        $value = null;

        /**
         * Chances are if the value is set
         * then the user is making their own.
         */
        if (isset($column['value'])) {

            return (string)$column['value'];
        }

        /**
         * If the value is NOT set then chances are
         * the user is using dot notation or
         * getting the value from the entry
         * by field slug.
         */
        if (!$value and isset($column['field']) and $entry instanceof EntryInterface) {

            $value = $column['field'];

            return $this->getValueFromEntryField($value, $entry);
        }

        /**
         * If the "relation" key is set then let's try
         * and resolve a value from a relation that is not
         * a field but a relation method on the model.
         */
        if (isset($column['relation'])) {

            $value = $column['relation'];

            /**
             * Try getting the
             */
            $value = $this->getValueFromRelation($value, $entry);
        }

        return $value;
    }

    /**
     * Try getting the value from the entry object.
     * If nothing is found then pass back the value
     * as it was passed in originally.
     *
     * @param mixed          $value
     * @param EntryInterface $entry
     * @return mixed
     */
    protected function getValueFromEntryField($value, EntryInterface $entry)
    {
        $parts = explode('.', $value);

        /**
         * If the value is or starts with a valid field
         * this will return the value or the FieldType
         * presenter for said field.
         */
        if ($value = $entry->getFieldValue($parts[0])) {

            $value = $this->parseValue($value, $parts);
        }

        return $value;
    }

    /**
     * Try getting the value from the entry object
     * based on a relation on it's model. This could be
     * a custom relation or a reverse relation compiled
     * to the base model even.
     *
     * @param $value
     * @param $entry
     */
    protected function getValueFromRelation($value, EntryInterface $entry)
    {
        $parts = explode('.', $value);

        /**
         * If the value is or starts with a valid property
         * this will return the value or the FieldType
         * presenter for said field.
         */
        if ($value = $entry->getRelation($parts[0])) {

            $value = $this->parseValue($value, $parts);
        }

        return $value;
    }

    /**
     * Parse the value into any decorating standards.
     *
     * @param mixed $value
     * @param array $parts
     * @return mixed
     */
    protected function parseValue($value, array $parts)
    {
        /**
         * If the value is dot notated then try and parse
         * the values inward on the entry / presenter.
         */
        if (count($parts) > 1 and $value) {

            $value = $this->parseDotNotation($value, $parts);
        }

        return $value;
    }

    /**
     * Recur into a value object to extract the dot
     * notated value that has been exploded into parts.
     *
     * @param mixed $value
     * @param array $parts
     * @return mixed
     */
    protected function parseDotNotation($value, array $parts)
    {
        foreach (array_slice($parts, 1) as $part) {

            try {

                $value = $value->$part;
            } catch (\Exception $e) {

                try {

                    $value = $value[$part];
                } catch (\Exception $e) {

                    /**
                     * You fucked up.
                     */
                    $value = null;
                }
            }
        }

        return $value;
    }

    /**
     * Set the field to the slug if the slug is a valid field.
     *
     * @param array $column
     * @param Table $table
     */
    protected function guessField(array &$column, Table $table)
    {
        if ($stream = $table->getStream()) {

            if (!isset($column['field']) and $field = $stream->getField($column['slug'])) {

                $column['field'] = $column['slug'];
            }
        }
    }
}
 