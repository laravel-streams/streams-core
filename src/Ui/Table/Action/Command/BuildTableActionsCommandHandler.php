<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionBuilder;

/**
 * Class BuildTableActionsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class BuildTableActionsCommandHandler
{

    /**
     * The action builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Action\ActionBuilder
     */
    protected $builder;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param ActionBuilder $builder
     */
    public function __construct(ActionBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build actions and load them to the table.
     *
     * @param BuildTableActionsCommand $command
     */
    public function handle(BuildTableActionsCommand $command)
    {
        $builder = $command->getBuilder();

        $this->builder->build($builder);
    }
}
