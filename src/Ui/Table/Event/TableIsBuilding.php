<?php namespace Anomaly\Streams\Platform\Ui\Table\Event;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class TableIsBuilding
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Event
 */
class TableIsBuilding
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new TableWasPosted instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the table object.
     *
     * @return TableBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
