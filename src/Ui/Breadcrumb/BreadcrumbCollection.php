<?php namespace Anomaly\Streams\Platform\Ui\Breadcrumb;

use Anomaly\Streams\Platform\Support\Collection;

/**
 * Class BreadcrumbCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Breadcrumb
 */
class BreadcrumbCollection extends Collection
{

    /**
     * Add a breadcrumb.
     *
     * @param      $key
     * @param null $url
     */
    public function add($key, $url)
    {
        $this->put($key, $url);
    }

    /**
     * Put a breadcrumb into the collection.
     *
     * @param string $key
     * @param string $value
     */
    public function put($key, $value)
    {
        if (!starts_with($value, 'http')) {
            $value = url($value);
        }

        parent::put($key, $value);
    }
}
