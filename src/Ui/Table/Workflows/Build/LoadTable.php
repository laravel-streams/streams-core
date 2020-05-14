<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\Table\Command\LoadTablePagination;
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
        $table = $builder->getTable();

        $table->addData('table', $table);

        if ($handler = $table->getOption('data')) {
            App::call($handler, compact('table'));
        }

        dispatch_now(new LoadTablePagination($table));

        if ($breadcrumb = $table->getOption('breadcrumb')) {
            $breadcrumbs->put($breadcrumb, '#');
        }



        if (request()->has('_async')) {
            return;
        }

        $options = $table->getOptions();
        $data    = $table->getData();

        assets('scripts.js', 'public::vendor/anomaly/core/js/table/table.js');

        $content = view(
            $options->get('table_view', 'streams::table/table'),
            $data
        )->render();

        $table->setContent($content);
        $table->addData('content', $content);

        dispatch_now(new SetResponse($builder));
    }
}
