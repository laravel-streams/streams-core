<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\ForwardsCalls;
use Anomaly\Streams\Platform\Repository\Repository;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

/**
 * Class Stream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Stream implements Arrayable, Jsonable
{

    use Macroable;
    use HasMemory;
    use Properties;
    use ForwardsCalls;
    use FiresCallbacks;

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes(array_merge([
            'name' => null,
            'slug' => null,
            'description' => null,

            'model' => null,
            'repository' => null,
            
            'location' => null,
            
            'fields' => [],
            'config' => [],

            'sortable' => false,
            'trashable' => true,
            'searchable' => true,
            'versionable' => true,
            'translatable' => false,
        ], $attributes));

        $this->buildProperties();

        $this->fill($attributes);
    }

    /**
     * Return the entry repository.
     * 
     * @return RepositoryInterface
     */
    public function repository()
    {
        return new Repository($this);
    }

    /**
     * Return the entry criteria.
     * 
     * @return CriteriaInterface
     */
    public function entries()
    {
        return $this
            ->repository()
            ->newCriteria();
    }

    /**
     * Return if the field name is meta.
     *
     * @param string $name
     *
     * @return bool
     */
    public function isMeta($name)
    {
        return in_array($name, [
            $this->key_name ?: 'id',
        ]);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Arr::make(Hydrator::dehydrate($this));
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
}
