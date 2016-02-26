<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Contract\RowInterface;
use Illuminate\Contracts\Container\Container;

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
     * The service container.
     *
     * @var Container
     */
    private $container;

    /**
     * Create a new RowFactory instance.
     *
     * @param Hydrator  $hydrator
     * @param Container $container
     */
    public function __construct(Hydrator $hydrator, Container $container)
    {
        $this->hydrator  = $hydrator;
        $this->container = $container;
    }

    /**
     * Make a row.
     *
     * @param  array $parameters
     * @return RowInterface
     */
    public function make(array $parameters)
    {
        $row = $this->container->make(Row::class, $parameters);

        $this->hydrator->hydrate($row, $parameters);

        return $row;
    }
}
