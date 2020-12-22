<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

/**
 * Class Entries
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Entries extends FieldType
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'rules' => [],
        ], $attributes));
    }

    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return $value;
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return string
     */
    public function restore($value)
    {
        return $this->expand($value);
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        $stream = Streams::entries($this->config['stream']);

        return new Collection(array_map(function ($value) use ($stream) {
            return $stream->newInstance($value);
        }, (array)$value));
    }
}
