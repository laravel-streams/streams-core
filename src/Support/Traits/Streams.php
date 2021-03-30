<?php

namespace Streams\Core\Support\Traits;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Facades\Streams as StreamsFacade;
use Streams\Core\Support\Facades\Hydrator;

/**
 * Trait Streams
 * 
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Streams
{

    use Prototype;

    /**
     * Return the model's stream instance.
     */
    public function stream()
    {
        if ($this->stream && $this->stream instanceof Stream) {
            return $this->stream();
        }

        return StreamsFacade::make($this->stream);
    }
}
