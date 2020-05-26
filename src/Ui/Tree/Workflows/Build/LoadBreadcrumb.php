<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Workflows\Build;

use Anomaly\Streams\Platform\Support\Breadcrumb;
use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class LoadBreadcrumb
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadBreadcrumb
{

    /**
     * Handle the command.
     *
     * @param TreeBuilder $builder
     * @param Breadcrumb $breadcrumbs
     */
    public function handle(TreeBuilder $builder, Breadcrumb $breadcrumbs)
    {
        if ($breadcrumb = $builder->tree->options->get('breadcrumb')) {
            $breadcrumbs->put($breadcrumb, '#');
        }
    }
}
