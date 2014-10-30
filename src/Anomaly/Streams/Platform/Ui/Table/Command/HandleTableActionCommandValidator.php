<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

/**
 * Class HandleTableActionCommandValidator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableActionCommandValidator
{

    /**
     * Validate the command.
     *
     * @param $command
     */
    public function validate($command)
    {
        $ui = $command->getUi();

        $actions = $ui->getActions();

        foreach ($actions as $action) {

            $this->validateSlug($action);
            $this->validateHandler($action);

        }
    }

    /**
     * Require the action slug.
     *
     * @param array $action
     * @throws \Exception
     */
    protected function validateSlug($action)
    {
        if (!isset($action['slug'])) {

            throw new \Exception("Table actions required the slug parameter.");

        }
    }

    /**
     * Require the handler parameter.
     *
     * The handler must also either be a closure
     * or an instance of the required interface.
     *
     * @param $action
     * @throws \Exception
     */
    protected function validateHandler($action)
    {
        $instance = 'Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface';

        // The handler must be set.
        if (!isset($action['handler'])) {

            throw new \Exception("Table actions required the handler parameter.");

        }

        // If not a class the handler must be a closure.
        if (!is_string($action['handler']) and !$action['handler'] instanceof \Closure) {

            throw new \Exception("Table action handlers must be a closure or instance of {$instance}.");

        }

        // If it is a class the handler must exist.
        if (is_string($action['handler']) and !class_exists($action['handler'])) {

            throw new \Exception("Table action class handler [{$action['handler']}] does not exist.");

        }

        // If it is a class and exists it must implement the interface.
        if (is_string($action['handler']) and !class_implements($action['handler'], $instance)) {

            throw new \Exception("Table action class handler [{$action['handler']}] must implement TableActionInterface.");

        }
    }

}
 