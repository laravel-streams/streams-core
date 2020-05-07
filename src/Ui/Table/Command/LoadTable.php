<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

/**
 * Class LoadTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadTable
{

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
     * @param Container            $container
     * @param BreadcrumbCollection $breadcrumbs
     */
    public function handle(Container $container, BreadcrumbCollection $breadcrumbs)
    {
        $table = $this->builder->getTable();

        $table->addData('table', $table);

        if ($handler = $table->getOption('data')) {
            $container->call($handler, compact('table'));
        }

        dispatch_now(new LoadTablePagination($table));

        if ($breadcrumb = $table->getOption('breadcrumb')) {
            $breadcrumbs->put($breadcrumb, '#');
        }
    }
}
