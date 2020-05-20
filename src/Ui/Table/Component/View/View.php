<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class View
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class View implements Arrayable, Jsonable
{

    use Properties;
    use FiresCallbacks;

    /**
     * The object attributes.
     *
     * @var array
     */
    protected $attributes = [
        'slug' => null,
        'text' => null,
        'icon' => null,
        'label' => null,
        'query' => null,
        'prefix' => null,
        'actions' => null,
        'buttons' => null,
        'columns' => null,
        'entries' => null,
        'filters' => null,
        'handler' => null,
        'options' => null,
        'active' => false,
        'attributes' => [],
        'context' => 'danger',
    ];

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }


    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param  string  $key
     * @param  mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
