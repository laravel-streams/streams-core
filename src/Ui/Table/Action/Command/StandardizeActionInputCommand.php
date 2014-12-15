<?php namespace Anomaly\Streams\Platform\Ui\Table\Action\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class StandardizeActionInputCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action\Command
 */
class StandardizeActionInputCommand
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new StandardizeActionInputCommand instance.
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
