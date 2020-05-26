<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Support\Breadcrumb;

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
     * @param TableBuilder $builder
     * @param Breadcrumb $breadcrumbs
     */
    public function handle(TableBuilder $builder, Breadcrumb $breadcrumbs)
    {
        if ($breadcrumb = $builder->table->options->get('breadcrumb')) {
            $breadcrumbs->put($breadcrumb, '#');
        }
    }
}
