<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Repository\Repository;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

/**
 * Class Stream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Stream implements StreamInterface
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
        $this->setAttributes([
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
        ]);

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
     * Forward calls to the repository.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->repository(), $method, $parameters);
    }
}
