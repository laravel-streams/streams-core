<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface;

/**
 * Class HeaderFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class HeaderFactory
{

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new HeaderFactory instance.
     *
     * @param Hydrator $hydrator
     */
    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * Make a header.
     *
     * @param  array $parameters
     * @return HeaderInterface
     */
    public function make(array $parameters)
    {
        $header = app()->make('Anomaly\Streams\Platform\Ui\Table\Component\Header\Header', $parameters);

        $this->hydrator->hydrate($header, $parameters);

        return $header;
    }
}
