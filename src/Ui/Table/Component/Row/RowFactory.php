<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\Contract\RowInterface;
use Illuminate\Contracts\Container\Container;

/**
 * Class RowFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RowFactory
{

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
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make a row.
     *
     * @param  array        $parameters
     * @return RowInterface
     */
    public function make(array $parameters)
    {
        $row = $this->container->make(Row::class, $parameters);

        Hydrator::hydrate($row, $parameters);

        return $row;
    }
}
