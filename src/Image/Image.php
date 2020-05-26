<?php

namespace Anomaly\Streams\Platform\Image;

use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Image\Concerns\CanOutput;
use Anomaly\Streams\Platform\Image\Concerns\HasSource;
use Anomaly\Streams\Platform\Image\Concerns\CanPublish;
use Anomaly\Streams\Platform\Image\Concerns\HasQuality;
use Anomaly\Streams\Platform\Image\Concerns\HasSources;
use Anomaly\Streams\Platform\Image\Concerns\HasSrcsets;
use Anomaly\Streams\Platform\Image\Concerns\HasVersion;
use Anomaly\Streams\Platform\Image\Concerns\HasFilename;
use Anomaly\Streams\Platform\Image\Concerns\HasExtension;
use Anomaly\Streams\Platform\Image\Concerns\HasAlterations;
use Anomaly\Streams\Platform\Image\Concerns\HasAttributes;

/**
 * Class Image
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Image
{
    use Macroable;

    use HasSource;
    use HasSources;
    use HasQuality;
    use HasSrcsets;
    use HasVersion;
    use HasFilename;
    use HasExtension;
    use HasAttributes;
    use HasAlterations;

    use CanOutput;
    use CanPublish;

    /**
     * Create a new Image instance.
     *
     * @param mixed $source
     */
    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * Map Intervention methods through alterations.
     *
     * @param string $method
     * @param array $parameters
     * @return $this
     */
    public function __call($method, array $parameters = [])
    {
        if ($this->isAlteration($method)) {
            return $this->addAlteration($method, $parameters);
        }

        if ($this->hasMacro(snake_case($method))) {

            $macro = static::$macros[$method];

            if ($macro instanceof \Closure) {
                return call_user_func_array($macro->bindTo($this, static::class), $parameters);
            }

            return $macro(...$parameters);
        }

        return $this->addAttribute($method, array_shift($parameters));
    }

    /**
     * Return string output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->img();
    }
}
