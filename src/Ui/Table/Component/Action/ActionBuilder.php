<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ActionBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionBuilder
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
     * Create a new ActionBuilder instance.
     *
     * @param ActionReader  $reader
     * @param ActionFactory $factory
     */
    public function __construct(ActionReader $reader, ActionFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
    }

    /**
     * Build the actions.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $actions = $table->getActions();
        $options = $table->getOptions();

        $prefix = $options->get('prefix');

        foreach ($builder->getActions() as $slug => $action) {

            $action = $this->reader->standardize($slug, $action);

            $action['size'] = 'sm';

            $action['attributes']['name']  = $prefix . 'action';
            $action['attributes']['value'] = $action['slug'];

            $action = $this->factory->make($action);

            $actions->put($action->getSlug(), $action);
        }
    }
}
