<?php namespace Anomaly\Streams\Platform\Ui\Breadcrumb;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new BreadcrumbCollection instance.
     *
     * @param Request $request
     * @param array   $items
     */
    public function __construct(Request $request, $items = [])
    {
        $this->request = $request;

        parent::__construct($items);
    }

    /**
     * Add a breadcrumb.
     *
     * @param      $key
     * @param null $url
     */
    public function add($key, $url = null)
    {
        if (!$url) {
            $url = $this->request->fullUrl();
        }

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
