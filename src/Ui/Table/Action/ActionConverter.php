<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ActionConverter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionConverter
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
     * Create a new ActionConverter instance.
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
     * Build actions.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
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
