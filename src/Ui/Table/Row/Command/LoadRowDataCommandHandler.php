<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Row\RowLoader;

/**
 * Class LoadRowDataCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Row\Command
 */
class LoadRowDataCommandHandler
{

    /**
     * The row loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Row\RowLoader
     */
    protected $loader;

    /**
     * Create a new RowLoader instance.
     *
     * @param RowLoader $loader
     */
    public function __construct(RowLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load view data for rows.
     *
     * @param LoadRowDataCommand $command
     */
    public function handle(LoadRowDataCommand $command)
    {
        $this->loader->load($command->getBuilder());
    }
}
