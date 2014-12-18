<?php namespace Anomaly\Streams\Platform\Ui\Table\Button\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class BuildTableButtonsCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Button\Command
 */
class BuildTableButtonsCommand
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTableButtonsCommand instance.
     *
     * @param TableBuilder $builder
     */
    function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the table builder.
     *
     * @return TableBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
