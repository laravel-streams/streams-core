<?php namespace Anomaly\Streams\Platform\Ui\Table\Button\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class LoadTableButtonsCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button\Command
 */
class LoadTableButtonsCommand
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new LoadTableButtonsCommand instance.
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
     * @return mixed
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
