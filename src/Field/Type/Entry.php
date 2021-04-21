<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Support\Facades\Streams;

/**
 * Class Entry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Entry extends Arr
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    // protected function initializePrototypeAttributes(array $attributes)
    // {
    //     return parent::initializePrototypeAttributes(array_merge([
    //         'rules' => [],
    //     ], $attributes));
    // }

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
     * @return EntryInterface|null
     */
    public function expand($value)
    {
        return Streams::entries($this->config['stream'])->newInstance($value);
    }
}
