<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\Action\ActionLoader;

/**
 * Class LoadActionsDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class LoadActionsDataCommandHandler
{

    /**
     * The action loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Action\ActionLoader
     */
    protected $loader;

    /**
     * Create a new LoadActionsDataCommandHandler instance.
     *
     * @param ActionLoader $loader
     */
    public function __construct(ActionLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load the view data for actions.
     *
     * @param LoadActionsDataCommand $command
     */
    public function handle(LoadActionsDataCommand $command)
    {
        $this->loader->load($command->getBuilder());
    }
}
