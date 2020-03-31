<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface;
use Illuminate\Contracts\Container\Container;

/**
 * Class HeaderFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class HeaderFactory
{

    /**
     * The service container.
     *
     * @var Container
     */
    private $container;

    /**
     * Create a new HeaderFactory instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make a header.
     *
     * @param  array           $parameters
     * @return HeaderInterface
     */
    public function make(array $parameters)
    {
        $header = $this->container->make(Header::class, $parameters);

        Hydrator::hydrate($header, $parameters);

        return $header;
    }
}
