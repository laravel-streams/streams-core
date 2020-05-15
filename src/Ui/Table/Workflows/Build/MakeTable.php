<?php

namespace Anomaly\Streams\Platform\Ui\Table\Workflows\Build;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\ActionCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderCollection;
use Illuminate\Support\Collection;

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
         * Default attributes.
         */
        $attributes = [

            'stream' => $builder->stream,

            'options' => new Collection(),
            'entries' => new Collection(),

            'rows' => new RowCollection(),
            'views' => new ViewCollection(),
            'actions' => new ActionCollection(),
            'filters' => new FilterCollection(),
            'headers' => new HeaderCollection(),
        ];

        /**
         * Default to configured.
         */
        if ($builder->table) {
            $builder->table = App::make($builder->table, compact('attributes'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->table) {
            $builder->table = App::make(Table::class, compact('attributes'));
        }
    }
}
