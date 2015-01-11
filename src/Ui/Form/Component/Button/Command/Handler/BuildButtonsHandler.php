<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\Form\Component\Button\Command\BuildButtons;

/**
 * Class BuildButtonsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button\Listener\Command
 */
class BuildButtonsHandler
{

    /**
     * The button builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Component\Button\ButtonBuilder
     */
    protected $builder;

    /**
     * Create a new BuildButtonsHandler instance.
     *
     * @param ButtonBuilder $builder
     */
    public function __construct(ButtonBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build buttons and load them to the form.
     *
     * @param BuildButtons $command
     */
    public function handle(BuildButtons $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
