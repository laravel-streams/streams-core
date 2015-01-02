<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

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
     * Make a header.
     *
     * @param  array $parameters
     * @return HeaderInterface
     */
    public function make(array $parameters)
    {
        $header = app()->make('Anomaly\Streams\Platform\Ui\Table\Component\Header\Header', $parameters);

        $this->hydrate($header, $parameters);

        return $header;
    }

    /**
     * Hydrate the header with it's remaining parameters.
     *
     * @param HeaderInterface $header
     * @param array           $parameters
     */
    protected function hydrate(HeaderInterface $header, array $parameters)
    {
        foreach ($parameters as $parameter => $value) {

            $method = camel_case('set_' . $parameter);

            if (method_exists($header, $method)) {
                $header->{$method}($value);
            }
        }
    }
}
