<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\FilterLoader;

/**
 * Class LoadFiltersDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Command
 */
class LoadFiltersDataCommandHandler
{

    /**
     * The filter loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Filter\FilterLoader
     */
    protected $loader;

    /**
     * Create a new LoadFiltersDataCommandHandler instance.
     *
     * @param FilterLoader $loader
     */
    public function __construct(FilterLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load the view data for filters.
     *
     * @param LoadFiltersDataCommand $command
     */
    public function handle(LoadFiltersDataCommand $command)
    {
        $this->loader->load($command->getBuilder());
    }
}
