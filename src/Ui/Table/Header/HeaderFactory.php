<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

/**
 * Class HeaderFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Header
 */
class HeaderFactory
{

    /**
     * The default header class.
     *
     * @var string
     */
    protected $header = 'Anomaly\Streams\Platform\Ui\Table\Header\Header';

    /**
     * Make a header.
     *
     * @param  array $parameters
     * @return HeaderInterface
     */
    public function make(array $parameters)
    {
        return app()->make(array_get($parameters, 'header', $this->header), $parameters);
    }
}
