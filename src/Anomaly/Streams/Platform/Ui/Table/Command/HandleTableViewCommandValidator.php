<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class HandleTableViewCommandValidator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableViewCommandValidator
{

    /**
     * Validate the command.
     *
     * @param $command
     */
    public function validate($command)
    {
        $ui = $command->getUi();

        $views = $ui->getViews();

        foreach ($views as $view) {

            $this->validateSlug($view);
            $this->validateHandler($view);

        }
    }

    /**
     * Require the view slug.
     *
     * @param $view
     * @throws \Exception
     */
    protected function validateSlug($view)
    {
        if (!isset($view['slug'])) {

            throw new \Exception("Table views required the slug parameter.");

        }
    }

    /**
     * Require the handler parameter.
     *
     * The handler must also either be a closure
     * or an instance of the required interface.
     *
     * @param $view
     * @throws \Exception
     */
    protected function validateHandler($view)
    {
        $instance = 'Anomaly\Streams\Platform\Ui\Table\Contract\TableViewInterface';

        // The handler must be set.
        if (!isset($view['handler'])) {

            throw new \Exception("Table views required the handler parameter.");

        }

        // If not a class the handler must be a closure.
        if (!is_string($view['handler']) and !$view['handler'] instanceof \Closure) {

            throw new \Exception("Table view handlers must be a closure or instance of {$instance}.");

        }

        // If it is a class the handler must exist.
        if (is_string($view['handler']) and !class_exists($view['handler'])) {

            throw new \Exception("Table view class handler [{$view['handler']}] does not exist.");

        }

        // If it is a class and exists it must implement the interface.
        if (is_string($view['handler']) and !class_implements($view['handler'], $instance)) {

            throw new \Exception("Table view class handler [{$view['handler']}] must implement TableViewInterface.");

        }
    }

}
 