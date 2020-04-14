<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Illuminate\Support\Collection;

/**
 * Class HeaderCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HeaderCollection extends Collection
{

    /**
     * Return the Vuetify data.
     */
    public function toVuetify()
    {
        return $this->toArray();
    }
}
