<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class BuildColumnsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column\Command
 */
class BuildColumnsCommand
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildColumnsCommand instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
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
