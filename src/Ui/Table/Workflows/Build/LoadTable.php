<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\Table\Command\SetResponse;

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
     * Handle the command.
     *
     * @param TableBuilder $builder
     * @param BreadcrumbCollection $breadcrumbs
     */
    public function handle(TableBuilder $builder, BreadcrumbCollection $breadcrumbs)
    {

        assets('scripts.js', 'public::vendor/anomaly/core/js/table/table.js');

        dispatch_now(new SetResponse($builder));
    }
}
