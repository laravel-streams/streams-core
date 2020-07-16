<?php

namespace Anomaly\Streams\Platform\Image;

use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Image\Concerns\CanOutput;
use Anomaly\Streams\Platform\Image\Concerns\CanPublish;
use Anomaly\Streams\Platform\Image\Concerns\HasQuality;
use Anomaly\Streams\Platform\Image\Concerns\HasSrcsets;
use Anomaly\Streams\Platform\Image\Concerns\HasVersion;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Image\Concerns\HasExtension;
use Anomaly\Streams\Platform\Image\Concerns\HasAlterations;

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

    use HasQuality;
    use HasSrcsets;
    use HasVersion;
    use HasExtension;
    use HasAlterations;

    use CanOutput;
    use CanPublish;

    use Properties;

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);

        $this->buildProperties();
    }

    /**
     * Set the filename.
     *
     * @param $filename
     * @return $this
     */
    public function rename($filename = null)
    {
        return $this->setAttribute('filename', $filename);
    }

    /**
     * Return a source tag.
     *
     * @param array $attributes
     * @return string
     */
    public function source(array $attributes = [])
    {
        $attributes = array_merge($this->attributes(['srcset' => $this->srcset() ?: $this->path()]), $attributes);

        return '<source' . HtmlFacade::attributes($attributes) . '>';
    }

    /**
     * Set the sources.
     *
     * @param array $sources
     * @return $this
     */
    public function sources(array $sources)
    {
        $this->sources = $sources;

        return $this;
    }

    /**
     * Return if the Image is remote or not.
     *
     * @return bool
     */
    public function isRemote()
    {
        return is_string($this->source) && Str::startsWith($this->source, ['http://', 'https://', '//']);
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

        if ($this->hasMacro(Str::snake($method))) {

            $macro = static::$macros[$method];

            if ($macro instanceof \Closure) {
                return call_user_func_array($macro->bindTo($this, static::class), $parameters);
            }

            return $macro(...$parameters);
        }

        $this->attributes[$method] = array_shift($parameters);

        return $this;
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
