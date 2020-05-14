<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Streams\Facades\Streams;

/**
 * Class SetTableStream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetStream
{

    /**
     * Handle the command.
     * 
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        if (!$builder->stream) {
            return;
        }

        $builder->stream = Streams::make($builder->stream);
    }
}
