<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Platform\Image\Concerns\CanPublish;
use Anomaly\Streams\Platform\Image\Concerns\HasVersion;

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
        $attributes = array_merge($this->attributes, $attributes);

        if (!isset($attributes['src'])) {
            $attributes['src'] = $this->path();
        }

        if ($srcset = $this->srcset()) {
            $attributes['srcset'] = $srcset;
        }

        if (!$alt && !isset($attributes['alt']) && config('streams.images.auto_alt', true)) {
            $attributes['alt'] = array_get(
                $this->attributes(),
                'alt',
                ucwords(
                    Str::humanize(
                        trim(basename(
                            $this->getOriginal(),
                            pathinfo($this->getOriginal(), PATHINFO_EXTENSION)
                        ), '.'),
                        '^a-zA-Z0-9'
                    )
                )
            );
        }

        return '<img' . HtmlFacade::attributes($attributes) . '>';
    }

    /**
     * Return a picture tag.
     *
     * @return string
     */
    public function picture(array $attributes = [])
    {
        $sources = implode("\n", array_map(function ($source) {
            return $source->source();
        }, $this->sources));

        $sources .= "\n" . $this->img($attributes);

        return "<picture>\n{$sources}\n</picture>";
    }

    /**
     * Encode the image.
     *
     * @param  null $format
     * @param  int $quality
     * @return $this
     */
    public function encode($format = null, $quality = null)
    {
        $this->setQuality($quality);
        $this->setExtension($format);
        $this->addAlteration('encode');

        return $this;
    }

    /**
     * Return the base64_encoded image source.
     *
     * @return string
     */
    public function base64()
    {
        $extension = $this->extension();

        if ($extension == 'svg') {
            $extension = 'svg+xml';
        }

        return 'data:image/' . $extension . ';base64,' . base64_encode($this->data());
    }

    /**
     * Return the URL to an image.
     *
     * @param  array $parameters
     * @param  null $secure
     * @return string
     */
    public function url(array $parameters = [], $secure = null)
    {
        return asset($this->getCachePath(), $parameters, $secure);
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
     * Return the image tag to a
     * data encoded inline image.
     *
     * @param  null $alt
     * @param  array $attributes
     * @return string
     */
    public function inline($alt = null, array $attributes = [])
    {
        $attributes['src'] = $this->base64();

        return $this->img($alt, $attributes);
    }

    /**
     * Return the CSS URL for background images.
     *
     * @return string
     */
    public function css()
    {
        return 'url(' . $this->path() . ')';
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
