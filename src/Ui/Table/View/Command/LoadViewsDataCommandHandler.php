<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\View\ViewLoader;

/**
 * Class LoadViewsDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View\Command
 */
class LoadViewsDataCommandHandler
{

    /**
     * The view loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\View\ViewLoader
     */
    protected $loader;

    /**
     * Create a new LoadViewsDataCommandHandler instance.
     *
     * @param ViewLoader $loader
     */
    public function __construct(ViewLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load the view data for table views.
     *
     * @param LoadViewsDataCommand $command
     */
    public function handle(LoadViewsDataCommand $command)
    {
        $this->loader->load($command->getBuilder());
    }
}
