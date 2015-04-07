<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableRepositoryInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class GetTableEntries
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class GetTableEntries implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTableColumnsCommand instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $table   = $this->builder->getTable();
        $model   = $this->builder->getModel();

        /**
         * If the builder has an entries handler
         * then call it through the container and
         * let it load the entries itself.
         */
        if ($handler = $table->getOption('entries')) {
            app()->call($handler, ['builder' => $this->builder]);
        }

        $entries = $table->getEntries();

        /**
         * If the entries have already been set on the
         * table then return. Nothing to do here.
         *
         * If the model is not set then they need
         * to load the table entries themselves.
         */
        if (!$entries->isEmpty() || !$model) {
            return;
        }

        /**
         * Resolve the model out of the container.
         */
        $repository = $table->getRepository();

        /**
         * If the repository is an instance of
         * TableRepositoryInterface use it.
         */
        if ($repository instanceof TableRepositoryInterface) {
            $table->setEntries($repository->get($this->builder));
        }
    }
}
