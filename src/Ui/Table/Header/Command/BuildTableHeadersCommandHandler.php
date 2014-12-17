<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\HeaderLoader;

/**
 * Class BuildTableHeadersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Command
 */
class BuildTableHeadersCommandHandler
{

    /**
     * The header loader.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Header\HeaderLoader
     */
    protected $loader;

    /**
     * Create a new TableBuildListener instance.
     *
     * @param HeaderLoader $loader
     */
    public function __construct(HeaderLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Build headers and load them to the table.
     *
     * @param BuildTableHeadersCommand $command
     */
    public function handle(BuildTableHeadersCommand $command)
    {
        $this->loader->load($command->getBuilder());
    }
}
