<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;

/**
 * Class GetTableEntries
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetTableEntries
{

    /**
     * Handle the command.
     * 
     * @param Container $container
     * @param TableBuilder $builder
     */
    public function handle(Container $container, TableBuilder $builder)
    {
        $model   = $builder->getModel();
        $entries = $builder->getEntries();

        /*
         * If the builder has an entries handler
         * then call it through the container and
         * let it load the entries itself.
         */
        if (is_string($entries) || $entries instanceof \Closure) {
            $container->call($entries, ['builder' => $builder], 'handle');
        }

        /**
         * If the builder already has a collection
         * of entries set on it then use those.
         */
        if ($entries instanceof Collection) {

            $builder->setTableEntries($entries);

            return;
        }

        $entries = $builder->getTableEntries();

        /*
         * If the entries have already been set on the
         * table then return. Nothing to do here.
         *
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!$entries->isEmpty() || !$model) {
            return;
        }

        /*
         * Resolve the model out of the container.
         */
        $repository = $builder->getRepository();

        if (is_string($repository) && class_exists($repository)) {
            $repository = $container->make($repository);
        }

        /*
         * If the repository is an instance of
         * TableRepositoryInterface use it.
         */
        if ($repository instanceof TableRepositoryInterface) {
            $builder->setTableEntries($repository->get($builder));
        }
    }
}
