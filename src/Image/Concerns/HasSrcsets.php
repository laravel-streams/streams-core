<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

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
        foreach ($this->getSrcsets() as $descriptor => $image) {
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
        foreach ($srcsets as $descriptor => &$alterations) {
            $image = $this->make(array_pull($alterations, 'image', $this->getImage()))->setOutput('url');

            foreach ($alterations as $method => $arguments) {
                if (is_array($arguments)) {
                    call_user_func_array([$image, $method], $arguments);
                } else {
                    call_user_func([$image, $method], $arguments);
                }
            }

            $alterations = $image;
        }

        $this->setSrcsets($srcsets);

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

    /**
     * Get the srcsets.
     *
     * @return array
     */
    public function getSrcsets()
    {
        return $this->srcsets;
    }

    /**
     * Set the srcsets.
     *
     * @param  array $srcsets
     * @return $this
     */
    public function setSrcsets(array $srcsets)
    {
        $this->srcsets = $srcsets;

        return $this;
    }
}
