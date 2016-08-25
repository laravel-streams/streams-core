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
     * @var TableBuilder
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
        $model   = $this->builder->getModel();
        $entries = $this->builder->getEntries();

        /**
         * If the builder has an entries handler
         * then call it through the container and
         * let it load the entries itself.
         */
        if (is_string($entries) || $entries instanceof \Closure) {
            app()->call($entries, ['builder' => $this->builder]);
        }

        $entries = $this->builder->getTableEntries();

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
        $repository = $this->builder->getRepository();

        /**
         * If the repository is an instance of
         * TableRepositoryInterface use it.
         */
        if ($repository instanceof TableRepositoryInterface) {
            $this->builder->setTableEntries($repository->get($this->builder));
        }
    }
}
