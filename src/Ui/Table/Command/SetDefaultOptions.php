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
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {

        /*
         * Set the default sortable option.
         */
        if ($builder->table->getOption('sortable') === null) {

            if ($builder->stream && $builder->stream->sortable) {
                $builder->table->setOption('sortable', true);
            }
        }

        /*
         * Default the table view based on the request.
         */
        if (!$builder->table->getOption('table_view')) {
            $builder->table->setOption('table_view', 'streams::table/table');
        }

        /*
         * Sortable tables have no pages.
         */
        if ($builder->table->getOption('sortable') === true) {
            $builder->table->setOption('limit', $builder->table->getOption('limit', 99999));
        }

        /*
         * Set the default breadcrumb.
         */
        if ($builder->table->getOption('breadcrumb') === null && $title = $builder->table->getOption('title')) {
            $builder->table->setOption('breadcrumb', $title);
        }

        /*
         * If the table ordering is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect.
         */
        if ($orderBy = $builder->getRequestValue('order_by')) {
            $builder->table->setOption('order_by', [$orderBy => $builder->getRequestValue('sort', 'asc')]);
        }

        /*
         * If the table limit is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect. Otherwise default.
         */
        if ($builder->table->getOption('limit') === null) {
            $builder->table->setOption(
                'limit',
                $builder->getRequestValue('limit', config('streams.system.per_page', 15))
            );
        }
    }
}
