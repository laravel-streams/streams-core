<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

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
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        if ($builder->repository instanceof RepositoryInterface) {
            return;
        }

        /**
         * Default to configured.
         */
        if ($builder->repository) {
            $builder->repository = App::make($builder->repository, compact('builder'));
        }

        /**
         * Fallback for Streams.
         */
        if (!$builder->repository && $builder->stream instanceof StreamInterface) {
            $builder->repository = $builder->stream->repository();
        }
    }
}
