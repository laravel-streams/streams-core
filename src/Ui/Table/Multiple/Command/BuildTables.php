<?php namespace Anomaly\Streams\Platform\Ui\Table\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Table\Multiple\MultipleTableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class BuildTables
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Multiple\Command
 */
class BuildTables implements SelfHandling
{

    /**
     * The multiple form builder.
     *
     * @var MultipleTableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTables instance.
     *
     * @param MultipleTableBuilder $builder
     */
    public function __construct(MultipleTableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /* @var TableBuilder $builder */
        foreach ($this->builder->getTables() as $builder) {

            $builder
                ->setOptions($this->builder->getOptions())
                ->setFilters($this->builder->getFilters())
                ->setButtons($this->builder->getButtons())
                ->setColumns($this->builder->getColumns())
                ->setActions($this->builder->getActions())
                ->build();
        }
    }
}
