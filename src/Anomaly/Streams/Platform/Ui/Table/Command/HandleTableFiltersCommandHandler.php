<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableFilterInterface;
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

            $slug = evaluate_key($filter, 'slug');

            /**
             * IF there is a value to work with
             * then pass it to the filter handler.
             */

            if ($value = $this->request->get($slug) or is_string($filter)) {

                if (is_string($filter)) {
                    $value = $this->request->get($filter);
                }

                if (isset($filter['type']) and $filter['type'] != 'field') {

                    $handler = $filter['handler'];

                } else {

                    $assignment = $ui->getModel()->getStream()->assignments->findByFieldSlug($filter);

                    if ($assignment instanceof AssignmentModel) {

                        $fieldType = $assignment->type();

                        if ($fieldType instanceof FieldTypeAddon) {

                            $handler = $fieldType->toFilter();

                        }

                    } else {

                        $handler = null;

                    }

                }

                if (is_string($handler)) {

                    $handler = app($handler);

                }

                if ($handler instanceof \Closure) {

                    if ($result = $handler($query, $value)) {

                        $query = $result;

                    }

                } elseif ($handler instanceof TableFilterInterface) {

                    /**
                     * If it's not a closure it MUST be an instance
                     * of the TableFilterInterface.
                     */
                    if ($result = $handler->handle($query, $value)) {

                        $query = $result;

                    }

                }

            }

        }

        return $query;
    }

}
 