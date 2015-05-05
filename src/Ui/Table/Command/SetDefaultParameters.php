<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultParameters
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetDefaultParameters implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultParameters instance.
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
        /**
         * Set the default views handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getViews()) {

            $views = str_replace('TableBuilder', 'TableViews', get_class($this->builder));

            if (class_exists($views)) {
                $this->builder->setViews($views . '@handle');
            }
        }

        /**
         * Set the default filters handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getFilters()) {

            $filters = str_replace('TableBuilder', 'TableFilters', get_class($this->builder));

            if (class_exists($filters)) {
                $this->builder->setFilters($filters . '@handle');
            }
        }

        /**
         * Set the default columns handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getColumns()) {

            $columns = str_replace('TableBuilder', 'TableColumns', get_class($this->builder));

            if (class_exists($columns)) {
                $this->builder->setColumns($columns . '@handle');
            }
        }

        /**
         * Set the default buttons handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getButtons()) {

            $buttons = str_replace('TableBuilder', 'TableButtons', get_class($this->builder));

            if (class_exists($buttons)) {
                $this->builder->setButtons($buttons . '@handle');
            }
        }

        /**
         * Set the default actions handler based
         * on the builder class. Defaulting to
         * no handler.
         */
        if (!$this->builder->getActions()) {

            $actions = str_replace('TableBuilder', 'TableActions', get_class($this->builder));

            if (class_exists($actions)) {
                $this->builder->setActions($actions . '@handle');
            }
        }
    }
}
