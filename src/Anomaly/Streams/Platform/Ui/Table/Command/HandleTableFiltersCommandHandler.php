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
                $filter['handler'] = $this->getHandler($filter, $table);

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
    protected function getHandler(array $filter, Table $table)
    {
        /**
         * If the handler is a string then auto complete
         * the class path if needed based on the table
         * object being used.
         */
        if (isset($filter['handler']) and is_string($filter['handler'])) {

            $utility = $table->getUtility();

            return $utility->autoComplete('Filter\\' . $filter['handler'], $table);
        }

        /**
         * If the handler is not set use the field value to resolve it.
         */
        if (!isset($filter['handler']) and $stream = $table->getStream()) {

            return $this->getHandlerFromField($filter, $stream);
        }
    }

    /**
     * Set the handler from a field.
     *
     * @param array           $filter
     * @param StreamInterface $stream
     */
    protected function getHandlerFromField(array $filter, StreamInterface $stream)
    {
        if (!isset($filter['field'])) {

            $filter['field'] = $filter['slug'];
        }

        return $stream->getFieldType($filter['field']);
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
        /**
         * If the handler is a string then call
         * it through the container.
         */
        if (is_string($filter['handler'])) {

            app()->call($filter['handler'], compact('table', 'value'));
        }

        /**
         * If the handler is a closure then call
         * it through the container.
         */
        if ($filter['handler'] instanceof \Closure) {

            app()->call($filter['handler'], compact('table', 'value'));
        }

        /**
         * If the handler is an instance of the
         * TableFilterInterface then use the
         * handle method as defined.
         */
        if ($filter['handler'] instanceof TableFilterInterface) {

            $filter['handler']->handle($table, $value);
        }

        /**
         * If the handler is a field type then
         * use it's filter method.
         */
        if ($filter['handler'] instanceof FieldType) {

            $filter['handler']->filter($table, $value);
        }
    }
}
 