<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class BuildTableHeadersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableHeadersCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildTableHeadersCommand $command
     * @return array
     */
    public function handle(BuildTableHeadersCommand $command)
    {
        $columns = [];

        $table = $command->getTable();

        $presets   = $table->getPresets();
        $expander  = $table->getExpander();
        $evaluator = $table->getEvaluator();

        /**
         * Loop and process all of the columns.
         */
        foreach ($table->getColumns() as $slug => $column) {

            // Expand minimal input.
            $column = $expander->expand($slug, $column);

            // Assure we have a field even if
            // it is a garbage value.
            if (!isset($column['field'])) {

                $column['field'] = $column['slug'];
            }

            // Automate what we can.
            $column = $presets->setViewPresets($column);

            // Evaluate the entire column.
            $column = $evaluator->evaluate($column, compact('table'));

            // Skip if disabled.
            if (array_get($column, 'enabled') === false) {

                continue;
            }

            // Build out our required data.
            $url     = $this->getUrl($column, $table);
            $heading = $this->getHeading($column, $table);
            $sorting = $this->getSorting($column, $table);

            $columns[] = compact('heading', 'sorting', 'url');
        }

        return $columns;
    }

    /**
     * Get the heading.
     *
     * @param array $column
     * @param Table $table
     * @return null|string
     */
    protected function getHeading(array $column, Table $table)
    {
        $heading = trans(array_get($column, 'heading'));

        // No heading desired.
        if ($heading === false) {

            return null;
        }

        /**
         * If we have a streams model on the table
         * try getting the heading from a field type.
         */
        if (!$heading and $stream = $table->getStream()) {

            $heading = $this->getHeadingFromField($column, $stream);
        }

        // TODO: Potentially guess a heading if not false

        return $heading;
    }

    /**
     * Get the heading from a field.
     *
     * @param array           $column
     * @param StreamInterface $stream
     * @return null|string
     */
    protected function getHeadingFromField(array $column, StreamInterface $stream)
    {
        $parts = explode('.', $column['field']);

        if ($type = $stream->getFieldType($parts[0])) {

            return trans($type->getName());
        }

        return null;
    }

    /**
     * Get the sorting status if any of the column.
     *
     * @param array $column
     * @param Table $table
     * @return null
     */
    protected function getSorting(array $column, Table $table)
    {
        $parts = explode('.', $column['field']);

        if ($stream = $table->getStream()) {

            return $this->getSortingFromField($column, $table, $stream);
        }

        return null;
    }

    /**
     * Get the sorting direction from a field.
     *
     * @param array           $column
     * @param Table           $table
     * @param StreamInterface $stream
     * @return null
     */
    protected function getSortingFromField(array $column, Table $table, StreamInterface $stream)
    {
        $parts = explode('.', $column['field']);

        if ($type = $stream->getFieldType($parts[0])) {

            return $this->getSortingDirectionFromType($table, $type);
        }

        return null;
    }

    /**
     * Get the sorting direction from a field type.
     *
     * @param Table     $table
     * @param FieldType $type
     * @return null
     */
    protected function getSortingDirectionFromType(Table $table, FieldType $type)
    {
        if ($value = app('request')->has($table->getPrefix() . 'order_by')) {

            list($column, $direction) = explode('|', $value);

            // Make sure the field type uses a column.
            if ($column == $type->getColumnName()) {

                return $direction;
            }
        }

        return null;
    }

    /**
     * Get the URL.
     *
     * This get's the column|direction and
     * appends the current URL.
     *
     * @param array $column
     * @param Table $table
     * @return null|string
     */
    protected function getUrl(array $column, Table $table)
    {
        $parts = explode('.', $column['field']);

        $column    = null;
        $direction = null;

        $key   = $table->getPrefix() . 'order_by';
        $value = app('request')->get($key);

        /**
         * If we're lucky enough to have a stream
         * model then try getting the column name
         * based on a field type.
         */
        if ($stream = $table->getStream()) {

            $type = $stream->getFieldType($parts[0]);

            if ($type) {

                $column = $type->getColumnName();
            }
        }

        /**
         * If we don't have a column yet the
         * just set the slug as the column.
         */
        if (!$column) {

            $column = $column['slug'];
        }

        if (is_numeric($column)) {

            return null;
        }

        /**
         * Great - we have a column to order by so
         * let's put the query together based on
         * our column / direction and merge it
         * into the existing query string.
         */
        $direction = ends_with($value, 'asc') ? 'desc' : 'asc';

        $variables = app('request')->all();

        $variables[$key] = $column . '|' . $direction;

        return app('request')->url('/') . '?' . http_build_query($variables);
    }
}
 