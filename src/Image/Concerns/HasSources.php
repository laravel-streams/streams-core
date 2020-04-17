<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use Collective\Html\HtmlFacade;

/**
 * Trait HasSources
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasSources
{

    /**
     * The image sources.
     *
     * @var array
     */
    protected $sources;

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
}
