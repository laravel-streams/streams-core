<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use Illuminate\Support\Str;

/**
 * Trait HasSource
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasSource
{

    /**
     * The image source.
     *
     * @var mixed
     */
    protected $source;

    /**
     * Return if the Image is remote or not.
     *
     * @return bool
     */
    public function isRemote()
    {
        return is_string($this->source) && Str::startsWith($this->source, ['http://', 'https://', '//']);
    }

}
