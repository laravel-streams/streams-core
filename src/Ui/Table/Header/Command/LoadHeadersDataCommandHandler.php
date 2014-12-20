<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\HeaderLoader;

/**
 * Class LoadHeadersDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Command
 */
class LoadHeadersDataCommandHandler
{

    /**
     * The header loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Header\HeaderLoader
     */
    protected $loader;

    /**
     * Create a new LoadHeadersDataCommandHandler instance.
     *
     * @param HeaderLoader $loader
     */
    public function __construct(HeaderLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load the view data for headers to the table.
     *
     * @param LoadHeadersDataCommand $command
     */
    public function handle(LoadHeadersDataCommand $command)
    {
        $this->loader->load($command->getBuilder());
    }
}
