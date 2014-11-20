<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class HandleTableFiltersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableFiltersCommandHandler
{

    /**
     * Handle the command.
     *
     * @param HandleTableFiltersCommand $command
     * @return mixed
     */
    public function handle(HandleTableFiltersCommand $command)
    {
        $table = $command->getTable();

        $filters  = $table->getFilters();
        $expander = $table->getExpander();

        /**
         * Loop through all the filters and look
         * for input with value according to each
         * filter's slug.
         */
        foreach ($filters as $slug => $filter) {

            // Expand minimal input into something useful.
            $filter = $expander->expand($slug, $filter);

            // Get the input key.
            $key = $this->getKey($filter, $table);

            /**
             * IF there is a value to work with
             * then pass it to the filter handler.
             */
            if ($value = app('request')->get($key)) {

                // Set and run the filter.
                $this->setHandler($filter, $table);
                $this->runHandler($filter, $table, $value);
            }
        }
    }

    /**
     * Get the filter key.
     *
     * @param array $filter
     * @param Table $table
     * @return string
     * @throws \Exception
     */
    protected function getKey(array $filter, Table $table)
    {
        return $table->getPrefix() . 'filter_' . $filter['slug'];
    }

    /**
     * Set the handler.
     *
     * @param array $filter
     * @param Table $table
     * @return mixed
     */
    protected function setHandler(array &$filter, Table $table)
    {
        /**
         * If the handler is a class path
         * then make it with the container.
         */
        if (isset($filter['handler']) and is_string($filter['handler'])) {

            $filter['handler'] = app()->make($filter['handler'], compact('ui'));
        }

        /**
         * If the handler is not set use the slug or field to resolve it.
         */
        if (!isset($filter['handler']) and $stream = $table->getStream()) {

            $this->setHandlerFromField($filter, $stream);
        }
    }

    /**
     * Set the handler from a field.
     *
     * @param array           $filter
     * @param StreamInterface $stream
     */
    protected function setHandlerFromField(array &$filter, StreamInterface $stream)
    {
        if (!isset($filter['field'])) {

            $filter['field'] = $filter['slug'];
        }

        $filter['handler'] = $stream->getFieldType($filter['field']);
    }

    /**
     * Run the handler.
     *
     * @param array $filter
     * @param Table $table
     * @param       $value
     */
    protected function runHandler(array $filter, Table $table, $value)
    {
        if ($filter['handler'] instanceof \Closure) {

            app()->call($filter['handler'], compact('table', 'value'));
        }

        if ($filter['handler'] instanceof TableFilterInterface) {

            $filter['handler']->handle($table, $value);
        }

        if ($filter['handler'] instanceof FieldType) {

            $table->setQuery($filter['handler']->filter($table->getQuery(), $value));
        }
    }
}
 