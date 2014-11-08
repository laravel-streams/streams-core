<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableViewInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableUtility;
use Illuminate\Http\Request;

/**
 * Class HandleTableViewCommandHandler
 *
 * Handle the query hook for table views.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableViewCommandHandler
{

    /**
     * The HTTP request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The table utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableUtility
     */
    protected $utility;

    /**
     * Create a new HandleTableViewCommandHandler instance.
     *
     * @param Request      $request
     * @param TableUtility $utility
     */
    function __construct(Request $request, TableUtility $utility)
    {
        $this->request = $request;
        $this->utility = $utility;
    }

    /**
     * Handle the command.
     *
     * @param HandleTableViewCommand $command
     * @return mixed
     */
    public function handle(HandleTableViewCommand $command)
    {
        $table    = $command->getTable();
        $query = $command->getQuery();

        $appliedView = $this->request->get($table->getPrefix() . 'view');

        foreach ($table->getViews() as $order => $view) {

            // Standardize input.
            $view = $this->standardize($view);

            // Get our defaults and merge them in.
            $defaults = $this->getDefaults($view, $table);

            $view = array_merge($defaults, $view);

            // If the view is applied then handle it.
            if ($view['slug'] == $appliedView or !$appliedView and $order == 0) {

                $handler = $this->getHandler($view, $table);
                $query   = $this->runHandler($view, $handler, $query);
            }
        }

        return $query;
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $view
     * @return array
     */
    protected function standardize($view)
    {
        // If the view is a string set as type / slug.
        if (is_string($view)) {

            $view = [
                'type' => $view,
                'slug' => $view,
            ];
        }

        return $view;
    }

    /**
     * Get default configuration if any.
     * Then run everything back through evaluation.
     *
     * @param $view
     * @param $table
     * @return array|mixed|null
     */
    protected function getDefaults($view, $table)
    {
        if (isset($view['type']) and $defaults = $this->utility->getViewDefaults($view['type'])) {

            return $this->utility->evaluate($defaults, [$table]);
        }

        return [];
    }

    /**
     * Get the handler.
     *
     * @param array   $view
     * @param Table $table
     * @return mixed
     */
    protected function getHandler(array $view, Table $table)
    {
        if (is_string($view['handler'])) {

            return app()->make($view['handler'], compact('ui'));
        }

        return $view['handler'];
    }

    /**
     * Run the query handler.
     *
     * @param array $view
     * @param       $handler
     * @param       $query
     * @return mixed
     * @throws \Exception
     */
    protected function runHandler(array $view, $handler, $query)
    {
        if ($handler instanceof \Closure) {

            $query = $handler($query);
        }

        if ($handler instanceof TableViewInterface) {

            $query = $handler->handle($query);
        }

        if (!$query) {

            throw new \Exception("Table view handler [{$view['slug']}] must return the query object.");
        }

        return $query;
    }
}
 