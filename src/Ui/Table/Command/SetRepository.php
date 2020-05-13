<?php

namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;

/**
 * Create a new SetRepository instance.
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetRepository
{

    /**
     * Handle the command.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {

        if ($builder->repository instanceof TableRepositoryInterface) {
            return;
        }

        if ($builder->repository) {
            $builder->repository = App::make($builder->repository, compact('builder'));
        }

        if (!$builder->repository && $builder->stream instanceof StreamInterface) {
            $builder->repository = $builder->stream->repository();
        }

        if ($builder->repository instanceof TableRepositoryInterface) {
            return;
        }

        throw new \Exception("Please define the [repository] and/or [stream] attribute.");
    }
}
