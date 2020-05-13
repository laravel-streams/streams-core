<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Command;

use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;

/**
 * Class LoadTree
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadTree
{

    /**
     * The tree builder.
     *
     * @var TreeBuilder
     */
    protected $builder;

    /**
     * Create a new LoadTree instance.
     *
     * @param TreeBuilder $builder
     */
    public function __construct(TreeBuilder $builder)
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
        $tree = $this->builder->getTree();

        $tree->addData('tree', $tree);

        if ($handler = $tree->getOption('data')) {
            $container->call($handler, compact('tree'));
        }

        if ($breadcrumb = $tree->getOption('breadcrumb')) {
            $breadcrumbs->put($breadcrumb, '#');
        }
    }
}
