<?php namespace Anomaly\Streams\Platform\Ui\Table\Button\Command;

use Anomaly\Streams\Platform\Ui\Table\Button\ButtonBuilder;

/**
 * Class BuildTableButtonsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Button\Command
 */
class BuildTableButtonsCommandHandler
{

    /**
     * The button builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Button\ButtonBuilder
     */
    protected $builder;

    /**
     * Create a new TableLoadListener instance.
     *
     * @param ButtonBuilder $builder
     */
    public function __construct(ButtonBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build buttons and load them to the table.
     *
     * @param BuildTableButtonsCommand $command
     */
    public function handle(BuildTableButtonsCommand $command)
    {
        $this->builder->load($command->getBuilder());
    }
}
