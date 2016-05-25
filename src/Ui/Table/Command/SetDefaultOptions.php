<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class SetDefaultOptions
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Command
 */
class SetDefaultOptions implements SelfHandling
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new SetDefaultOptions instance.
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
     * @param ModuleCollection $modules
     */
    public function handle(ModuleCollection $modules)
    {
        $table = $this->builder->getTable();

        /**
         * Set the default sortable option.
         */
        if ($table->getOption('sortable') === null) {

            $stream = $table->getStream();

            if ($stream && $stream->isSortable()) {
                $table->setOption('sortable', true);
            }
        }

        /**
         * Sortable tables have no pages.
         */
        if (($table->getOption('sortable') === true)) {
            $table->setOption('limit', $table->getOption('limit', 99999));
        }

        /**
         * Set the default breadcrumb.
         */
        if ($table->getOption('breadcrumb') === null && $title = $table->getOption('title')) {
            $table->setOption('breadcrumb', $title);
        }

        /**
         * If the table ordering is currently being overridden
         * then set the values from the request on the builder
         * last so it actually has an effect.
         */
        if ($orderBy = $this->builder->getRequestValue('order_by')) {
            $table->setOption('order_by', [$orderBy => $this->builder->getRequestValue('sort', 'asc')]);
        }

        /**
         * If the permission is not set then
         * try and automate it.
         */
        if ($table->getOption('permission') === null && ($module = $modules->active(
            )) && ($stream = $this->builder->getTableStream())
        ) {
            $table->setOption('permission', $module->getNamespace($stream->getSlug() . '.read'));
        }
    }
}
