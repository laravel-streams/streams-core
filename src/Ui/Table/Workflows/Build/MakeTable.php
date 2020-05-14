<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class MakeTable
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class MakeTable
{

    /**
     * Handle the step.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if ($builder->table instanceof Table) {
            return;
        }

        /**
         * Default to configured.
         */
        if ($builder->table) {
            $builder->table = App::make($builder->table, [
                'stream' => $builder->stream,
            ]);
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->table) {
            $builder->table = App::make(Table::class, [
                'stream' => $builder->stream,
            ]);
        }
    }
}
