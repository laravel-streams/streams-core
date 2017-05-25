<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableRepository;
use Anomaly\Streams\Platform\Entry\EntryTableRepository;
use Anomaly\Streams\Platform\Model\EloquentTableRepository;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SetRepository
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetRepository
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetRepository instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Container $container
     */
    public function handle(Container $container)
    {
        /*
         * Set the default options handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getRepository()) {

            $model = $this->builder->getTableModel();

            if (!$this->builder->getRepository() && $model instanceof EntryModel) {
                $this->builder->setRepository($container->makeWith(EntryTableRepository::class, compact('model')));
            } elseif (!$this->builder->getRepository() && $model instanceof EloquentModel) {
                $this->builder->setRepository($container->makeWith(EloquentTableRepository::class, compact('model')));
            } elseif (!$this->builder->getRepository() && $model instanceof Model) {
                $this->builder->setRepository($container->makeWith(TableRepository::class, compact('model')));
            }
        }
    }
}
