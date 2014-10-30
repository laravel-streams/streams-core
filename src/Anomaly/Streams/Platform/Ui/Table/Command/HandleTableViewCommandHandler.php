<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Table\TableUi;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableViewInterface;

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
     * Create a new HandleTableViewCommandHandler instance.
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
     * @param HandleTableViewCommand $command
     * @return mixed
     */
    public function handle(HandleTableViewCommand $command)
    {
        $ui    = $command->getUi();
        $query = $command->getQuery();

        $appliedView = $this->request->get($ui->getPrefix() . 'view');

        foreach ($ui->getViews() as $order => $view) {

            // Standardize input.
            $view = $this->standardize($view);

            // If the view is applied then handle it.
            if ($view['slug'] == $appliedView or !$appliedView and $order == 0) {

                $handler = $this->getHandler($view, $ui);
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
     * Get the handler.
     *
     * @param array   $view
     * @param TableUi $ui
     * @return mixed
     */
    protected function getHandler(array $view, TableUi $ui)
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
 