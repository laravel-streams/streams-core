<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

/**
 * Class HeaderFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header
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
     * @param array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (isset($parameters['header']) && class_exists($parameters['header'])) {
            return app()->make($parameters['header'], $parameters);
        }

        return app()->make($this->header, $parameters);
    }
}
