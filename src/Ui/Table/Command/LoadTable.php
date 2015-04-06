<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Event\TableIsLoading;
use Anomaly\Streams\Platform\Ui\Table\Event\TableWasLoaded;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class LoadTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class LoadTable implements SelfHandling
{

    use DispatchesCommands;

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new LoadTable instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Container    $container
     * @param ViewTemplate $template
     */
    public function handle(Container $container, ViewTemplate $template, Dispatcher $events)
    {
        $this->builder->fire('loading');
        $events->fire(new TableIsLoading($this->builder));

        $table = $this->builder->getTable();

        $table->addData('table', $table);

        if ($handler = $table->getOption('data')) {
            $container->call($handler, compact('table'));
        }

        if ($layout = $table->getOption('layout_view')) {
            $template->put('layout', $layout);
        }

        $this->dispatch(new LoadTablePagination($table));

        $this->builder->fire('loaded');
        $events->fire(new TableWasLoaded($this->builder));
    }
}
