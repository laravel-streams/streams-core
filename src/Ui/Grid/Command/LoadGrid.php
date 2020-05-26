<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Command;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;
use Anomaly\Streams\Platform\Support\Breadcrumb;

/**
 * Class LoadGrid
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadGrid
{

    /**
     * The grid builder.
     *
     * @var GridBuilder
     */
    protected $builder;

    /**
     * Create a new LoadGrid instance.
     *
     * @param GridBuilder $builder
     */
    public function __construct(GridBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Container            $container
     * @param Breadcrumb $breadcrumbs
     */
    public function handle(Container $container, Breadcrumb $breadcrumbs)
    {
        $grid = $this->builder->getGrid();

        $grid->addData('grid', $grid);

        if ($handler = $grid->getOption('data')) {
            $container->call($handler, compact('grid'));
        }

        if ($breadcrumb = $grid->getOption('breadcrumb')) {
            $breadcrumbs->put($breadcrumb, '#');
        }
    }
}
