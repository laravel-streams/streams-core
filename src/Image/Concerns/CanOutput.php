<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Platform\Image\Concerns\CanPublish;
use Anomaly\Streams\Platform\Image\Concerns\HasVersion;
use Collective\Html\HtmlFacade;

/**
 * Trait CanOutput
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait CanOutput
{

    /**
     * Return the image tag to an image.
     *
     * @param  null $alt
     * @param  array $attributes
     * @return string
     */
    public function img($alt = null, array $attributes = [])
    {
        $attributes = array_merge($this->attributes(), $attributes);

        if (!isset($attributes['src'])) {
            $attributes['src'] = $this->path();
        }
        
        // if ($srcset = $this->srcset()) {
        //     $attributes['srcset'] = $srcset;
        // }

        if (!$alt && config('streams::images.auto_alt', true)) {
            $attributes['alt'] = array_get(
                $this->attributes(),
                'alt',
                ucwords(
                    humanize(
                        trim(basename($this->getOriginal(), $this->extension()), '.'),
                        '^a-zA-Z0-9'
                    )
                )
            );
        }

        return '<img ' . HtmlFacade::attributes($attributes) . '>';
    }

    /**
     * Return the path to an image.
     *
     * @return string
     */
    public function path()
    {
        return Request::getBasePath() . $this->getCachePath();
    }
    
    /**
     * Return the image contents.
     *
     * @return string
     */
    public function data()
    {

        /**
         * @var HasVersion|CanPublish $this
         */
        return file_get_contents(public_path(
            $this
                ->setVersion(false)
                ->getCachePath()
        ));
    }

}
