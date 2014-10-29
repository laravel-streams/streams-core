<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Table\TableUi;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableFilterInterface;

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
     * The HTTP request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new HandleTableFiltersCommandHandler instance.
     *
     * @param Request $request
     */
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the command.
     *
     * @param HandleTableFiltersCommand $command
     * @return mixed
     */
    public function handle(HandleTableFiltersCommand $command)
    {
        $ui    = $command->getUi();
        $query = $command->getQuery();

        $filters = $ui->getFilters();

        $prefix = $ui->getPrefix() . 'filter_';

        /**
         * Loop through all the filters and look
         * for input with value according to each
         * filter's slug.
         */
        foreach ($filters as $filter) {

            $slug = $this->getFilterSlug($filter, $prefix, $ui);

            /**
             * IF there is a value to work with
             * then pass it to the filter handler.
             */
            if ($value = $this->request->get($slug)) {

                $handler = $this->getHandler($filter, $ui);
                $query   = $this->runHandler($slug, $handler, $query, $value);

            }

        }

        return $query;
    }

    /**
     * Get the filter slug.
     *
     * @param         $filter
     * @param         $prefix
     * @param TableUi $ui
     * @return string
     * @throws \Exception
     */
    protected function getFilterSlug($filter, $prefix, TableUi $ui)
    {
        if (is_string($filter)) {

            $stream = $ui->getModel();

            $assignment = $stream->getAssignmentFromField($filter);

            if (!$field = $assignment->field) {

                throw new \Exception("Filter field [{$filter}] does not exist.");

            }

            return $prefix . $field->slug;

        }

        return $prefix . $filter['slug'];
    }

    /**
     * Get the filter handler.
     *
     * @param $filter
     * @param $ui
     * @return \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeFilter|mixed|null
     */
    protected function getHandler($filter, $ui)
    {
        if (is_string($filter)) {

            return $this->getHandlerFromField($filter, $ui);

        }

        if (is_string($filter['handler'])) {

            return app()->make($filter['handler'], compact('ui'));

        }

        return $filter['handler'];
    }

    /**
     * Get the handler object from a field slug.
     *
     * @param $filter
     * @param $ui
     * @return \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeFilter|null
     */
    protected function getHandlerFromField($filter, $ui)
    {
        $stream = $ui->getModel();

        $type = $stream->getTypeFromField($filter);

        if ($type instanceof FieldTypeAddon) {

            return $type->toFilter();

        }

        return null;
    }

    /**
     * Run the handler.
     *
     * @param $slug
     * @param $handler
     * @param $query
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    protected function runHandler($slug, $handler, $query, $value)
    {
        if ($handler instanceof \Closure) {

            $query = $handler($query);

        }

        if ($handler instanceof TableFilterInterface) {

            $query = $handler->handle($query, $value);

        }

        if (!$query) {

            throw new \Exception("Table filter handler [{$slug}] must return the query object.");

        }

        return $query;
    }

}
 