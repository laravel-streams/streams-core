<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;
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
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        $ui    = $command->getUi();
        $query = $command->getQuery();

        $filters = $ui->getFilters();
        $prefix  = $this->getPrefix($ui);

        /**
         * Loop through all the filters and look
         * for input with value according to each
         * filter's slug.
         */
        foreach ($filters as $filter) {

            $filter = $this->standardize($filter);

            $slug = $prefix . $this->getSlug($filter, $ui);

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
     * Get the prefix.
     *
     * @param $ui
     * @return string
     */
    protected function getPrefix($ui)
    {
        return $ui->getPrefix() . 'filter_';
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
         * If the filter is a string it
         * is a field slug.
         */
        if (is_string($filter)) {

            $filter = [
                'type' => 'field',
                'slug' => 'field',
            ];

        }

        return $filter;
    }

    /**
     * Get the slug.
     *
     * @param $filter
     * @param $ui
     * @return mixed
     * @throws \Exception
     */
    protected function getSlug($filter, $ui)
    {
        if ($filter['type'] == 'field') {

            $stream = $ui->getModel();

            $assignment = $stream->getAssignmentFromField($filter);

            if (!$field = $assignment->field) {

                throw new \Exception("Filter field [{$filter}] does not exist.");

            }

            return $field->slug;

        }

        return $filter['slug'];
    }

    /**
     * Get the filter handler.
     *
     * @param $filter
     * @param $ui
     * @return \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeFilter|null
     */
    protected function getHandler($filter, $ui)
    {
        if ($filter['type'] == 'field') {

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

        if ($type) {

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
 