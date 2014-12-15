<?php namespace Anomaly\Streams\Platform\Ui\Table\Button\Command;

use Anomaly\Streams\Platform\Ui\Table\Button\ButtonFactory;

/**
 * Class LoadTableButtonsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button\Command
 */
class LoadTableButtonsCommandHandler
{

    /**
     * The button factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Button\ButtonFactory
     */
    protected $factory;

    /**
     * Create a new LoadTableButtonsCommandHandler instance.
     *
     * @param ButtonFactory $factory
     */
    public function __construct(ButtonFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param LoadTableButtonsCommand $command
     */
    public function handle(LoadTableButtonsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $buttons = $table->getButtons();

        foreach ($builder->getButtons() as $parameters) {
            $button = $this->factory->make($parameters);

            $buttons->push($button);
        }
    }
}
