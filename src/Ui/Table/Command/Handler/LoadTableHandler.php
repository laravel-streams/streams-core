<?php namespace Anomaly\Streams\Platform\Ui\Table\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Command\LoadTable;
use Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePagination;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Container\Container;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class LoadTableHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTableHandler
{

    use DispatchesCommands;

    /**
     * The view template.
     *
     * @var ViewTemplate
     */
    protected $template;

    /**
     * The IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create a new LoadTableHandler instance.
     *
     * @param Container    $container
     * @param ViewTemplate $template
     */
    public function __construct(Container $container, ViewTemplate $template)
    {
        $this->template  = $template;
        $this->container = $container;
    }

    /**
     * Handle the command.
     *
     * @param LoadTable $command
     */
    public function handle(LoadTable $command)
    {
        $table = $command->getTable();

        $table->addData('table', $table);

        if ($handler = $table->getOption('data')) {
            $this->container->call($handler, compact('table'));
        }

        if ($layout = $table->getOption('layout_view')) {
            $this->template->put('layout', $layout);
        }

        $this->dispatch(new LoadTablePagination($table));
    }
}
