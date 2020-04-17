<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Image\Facades\Images;

/**
 * Trait HasSrcsets
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasSrcsets
{

    /**
     * Image srcsets.
     *
     * @var array
     */
    protected $srcsets = [];

    /**
     * Return the image srcsets by set.
     *
     * @return array
     */
    public function srcset()
    {
        $sources = [];

        /* @var Image $image */
        foreach ($this->srcsets as $descriptor => $image) {
            $sources[] = $image->path() . ' ' . $descriptor;
        }

        return implode(', ', $sources);
    }

    /**
     * Set the srcsets/alterations.
     *
     * @param array $srcsets
     */
    public function srcsets(array $srcsets)
    {
        foreach ($srcsets as &$alterations) {

            if ($alterations instanceof Image) {
                continue;
            }

            $alterations = Images::make(array_pull($alterations, 'image', $this->getSource()))
                ->setAlterations($alterations)
                ->setOutput('url');
        }

        $this->srcsets = $srcsets;

        return $this;
    }

    /**
     * Add a srcsets.
     *
     * @param  string $media
     * @param  array $srcsets
     * @return $this
     */
    public function addSrcset($media, array $srcsets)
    {
        $this->srcsets[$media] = $srcsets;

        return $this;
    }
}
