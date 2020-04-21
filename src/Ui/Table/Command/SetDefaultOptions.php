<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class SetDefaultOptions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetDefaultOptions
{

    /**
     * Handle the command.
     *
     * @param ModuleCollection $modules
     * @param TableBuilder $builder
     */
    public function handle(ModuleCollection $modules, TableBuilder $builder)
    {
        $table = $builder->getTable();

        /*
         * Set the default sortable option.
         */
        if ($table->getOption('sortable') === null) {
            $stream = $table->getStream();

            if ($stream && $stream->isSortable()) {
                $table->setOption('sortable', true);
            }
        }

        /*
         * Default the table view based on the request.
         */
        if (!$builder->getTableOption('table_view')) {
            $builder->setTableOption('table_view', 'streams::table/table');
        }

        /*
         * Sortable tables have no pages.
         */
        if ($table->getOption('sortable') === true) {
            $table->setOption('limit', $table->getOption('limit', 99999));
        }

        /*
         * Set the default breadcrumb.
         */
        if ($table->getOption('breadcrumb') === null && $title = $table->getOption('title')) {
            $table->setOption('breadcrumb', $title);
        }

        /*
         * If the table ordering is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect.
         */
        if ($orderBy = $builder->getRequestValue('order_by')) {
            $table->setOption('order_by', [$orderBy => $builder->getRequestValue('sort', 'asc')]);
        }

        /*
         * If the table limit is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect. Otherwise default.
         */
        if ($table->getOption('limit') === null) {
            $table->setOption(
                'limit',
                $builder->getRequestValue('limit', config('streams.system.per_page', 15))
            );
        }

        /*
         * If the permission is not set then
         * try and automate it.
         */
        if (
            $table->getOption('permission') === null &&
            request()->segment(1) == 'admin' &&
            ($module = $modules->active()) && ($stream = $builder->getTableStream())
        ) {
            $table->setOption('permission', $module->getNamespace($stream->getSlug() . '.read'));
        }
    }
}
