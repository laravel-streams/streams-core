<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ViewBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ViewBuilder
{

    /**
     * Build the views.
     *
     * @param TableBuilder $builder
     */
    public static function handle(TableBuilder $builder)
    {
        $factory = app(ViewFactory::class);

        ViewInput::read($builder);

        foreach ($builder->views as $view) {
            if (array_get($view, 'enabled', true)) {
                $builder->table->addView($factory->make($view));
            }
        }
    }
}
