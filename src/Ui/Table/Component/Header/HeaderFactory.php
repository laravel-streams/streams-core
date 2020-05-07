<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

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
     * Make a header.
     *
     * @param  array           $parameters
     * @return Header
     */
    public function make(array $parameters)
    {
        $header = App::make(Header::class, $parameters);

        Hydrator::hydrate($header, $parameters);

        return $header;
    }
}
