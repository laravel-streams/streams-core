<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ActionLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionLoader
{

    use CommanderTrait;

    /**
     * The action reader.
     *
     * @var ActionReader
     */
    protected $reader;

    /**
     * The action factory.
     *
     * @var ActionFactory
     */
    protected $factory;

    /**
     * Create a new ActionLoader instance.
     *
     * @param ActionReader  $reader
     * @param ActionFactory $factory
     */
    function __construct(ActionReader $reader, ActionFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
    }

    /**
     * Load actions onto a collection.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $actions = $table->getActions();

        foreach ($builder->getActions() as $key => $parameters) {

            $parameters = $this->reader->standardize($key, $parameters);

            $action = $this->factory->make($parameters);

            $actions->put($action->getSlug(), $action);
        }
    }
}
