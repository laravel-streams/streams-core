<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Support\Presenter;
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

            // Assure a field even if it is garbage.
            if (!isset($column['field'])) {

                $column['field'] = $column['slug'];
            }

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

            $entry = app('streams.decorator')->decorate($entry);

            return $this->parseValue($value, $entry);
        }

        /**
         * If the "relation" key is set then let's try
         * and resolve a value from a relation that is not
         * a field but a relation method on the model.
         */
        if (isset($column['relation'])) {

            $value = $column['relation'];

            return view()->parse('{{' . $value . '}}', $entry);
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

    /**
     * Parse the value.
     *
     * @param $value
     * @param $entry
     * @return string
     */
    protected function parseValue($value, $entry)
    {
        foreach (explode('.', $value) as $property) {

            if ($entry instanceof Presenter or $entry instanceof EntryInterface) {

                $entry = $entry->{$property};

                continue;
            }
        }

        return (string)$entry;
    }
}
 