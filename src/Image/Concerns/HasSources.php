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
     * @return string
     */
    public function source()
    {
        $attributes = HtmlFacade::attributes([
            'srcset' => /*$this->srcset() ?: */$this->path() . ' 2x, ' . $this->path() . ' 1x'
        ]);

        return "<source {$attributes}>";
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
     * Get the sources.
     * 
     * @return array
     */
    public function getSources()
    {
        return $this->sources;
    }
}
