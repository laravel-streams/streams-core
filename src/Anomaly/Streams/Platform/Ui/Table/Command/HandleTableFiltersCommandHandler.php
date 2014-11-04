<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Http\Request;

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

        /**
         * Loop through all the filters and look
         * for input with value according to each
         * filter's slug.
         */
        foreach ($filters as $filter) {

            // Standardize the input.
            $filter = $this->standardize($filter);

            $slug = $this->getSlug($filter, $ui);

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
     * Get the filter slug.
     *
     * @param array   $filter
     * @param Table $ui
     * @return string
     * @throws \Exception
     */
    protected function getSlug(array $filter, Table $ui)
    {
        return $this->getPrefix($ui) . $filter['slug'];
    }

    /**
     * Get the prefix.
     *
     * @param Table $ui
     * @return string
     */
    protected function getPrefix(Table $ui)
    {
        return $ui->getPrefix() . 'filter_';
    }

    /**
     * Get the filter handler.
     *
     * @param array   $filter
     * @param Table $ui
     * @return \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeFilter|mixed|null
     */
    protected function getHandler(array $filter, Table $ui)
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
     * @param array   $filter
     * @param Table $ui
     * @return \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeFilter|null
     */
    protected function getHandlerFromField(array $filter, Table $ui)
    {
        $stream = $ui->getModel();

        $type = $stream->getTypeFromField($filter['field']);

        if ($type instanceof FieldType) {

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
 