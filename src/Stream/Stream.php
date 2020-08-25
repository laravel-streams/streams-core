<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Validator;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\ForwardsCalls;
use Anomaly\Streams\Platform\Repository\Repository;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Support\Traits\HasMemory;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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
     * Return the entry repository.
     * 
     * @todo Let's review this idea. Could use for allowing configuration of criteria too. Flat or in some kinda config array?
     * @return RepositoryInterface
     */
    public function repository()
    {
        $repository = $this->repository = $this->repository ?: Repository::class;

        return new $repository($this);
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
     * Return an entry validator.
     * 
     * @param $data
     * @return Validator
     */
    public function validator($data): Validator
    {
        $factory = App::make(Factory::class);

        if ($data instanceof EntryInterface) {
            $data = $data->getAttributes();
        }

        $rules = $this->attr('rules', []);

        $rules = array_map(function($rules) {
            return implode('|', array_unique($rules));
        }, $this->rules);

        return $factory->make($data, $rules);
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
