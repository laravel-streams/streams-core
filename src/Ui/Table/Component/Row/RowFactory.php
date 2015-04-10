<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Contract\RowInterface;

/**
 * Class RowFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Row
 */
class RowFactory
{

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new RowFactory instance.
     *
     * @param Hydrator $hydrator
     */
    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * Make a row.
     *
     * @param  array $parameters
     * @return RowInterface
     */
    public function make(array $parameters)
    {
        $row = app()->make('Anomaly\Streams\Platform\Ui\Table\Component\Row\Row', $parameters);

        $this->hydrator->hydrate($row, $parameters);

        return $row;
    }
}
