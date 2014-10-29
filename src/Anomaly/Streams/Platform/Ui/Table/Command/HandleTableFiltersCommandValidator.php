<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class HandleTableFiltersCommandValidator
{

    public function validate(HandleTableFiltersCommand $command)
    {
        $ui = $command->getUi();

        $filters = $ui->getFilters();

        foreach ($filters as $filter) {

            $this->validateSlug($filter);
            $this->validateHandler($filter);

        }
    }

    /**
     * Require the view slug.
     *
     * @param $filter
     * @throws \Exception
     */
    protected function validateSlug($filter)
    {
        if (!is_string($filter) and !isset($filter['slug'])) {

            throw new \Exception("Custom table filters require the slug parameter.");

        }
    }

    /**
     * Require the handler parameter.
     *
     * The handler must also either be a closure
     * or an instance of the required interface.
     *
     * @param $filter
     * @throws \Exception
     */
    protected function validateHandler($filter)
    {
        $instance = 'Anomaly\Streams\Platform\Ui\Table\Contract\TableFilterInterface';

        // If this is a string it's a field type. Great.
        if (is_string($filter)) {

            return;

        }

        // Otherwise the handler is required.
        if (!isset($filter['handler'])) {

            throw new \Exception("Table views required the handler parameter.");

        }

        // If it is not a string it must be a closure.
        if (!is_string($filter['handler']) and !$filter['handler'] instanceof \Closure) {

            throw new \Exception("Table view handlers must be a closure or instance of {$instance}.");

        }

        // If it is a class the class must exist.
        if (is_string($filter['handler']) and !class_exists($filter['handler'])) {

            throw new \Exception("Table view class handler [{$filter['handler']}] does not exist.");

        }

        // If it is a class and it exists it must implement the interface.
        if (is_string($filter['handler']) and !class_implements($filter['handler'], $instance)) {

            throw new \Exception("Table view class handler [{$filter['handler']}] must implement TableViewInterface.");

        }
    }

}
 