<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableRepository;

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
     * @param Container $container
     * @param TableBuilder $builder
     */
    public function handle(Container $container, TableBuilder $builder)
    {
        /*
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$builder->getRepository()) {
            
            $model = $builder->getTableModel();

            if (!$builder->getRepository() && $model instanceof Model) {
                $builder->setRepository($container->make(TableRepository::class, compact('model')));
            }
        }
    }
}
