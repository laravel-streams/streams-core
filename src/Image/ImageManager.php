<?php

namespace Anomaly\Streams\Platform\Image;

use Mobile_Detect;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageManager as Intervention;

/**
 * Class ImageManager
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ImageManager
{

    /**
     * The original filename.
     *
     * @var null|string
     */
    protected $original = null;

    /**
     * Image srcsets.
     *
     * @var array
     */
    protected $srcsets = [];

    /**
     * Image sources.
     *
     * @var array
     */
    protected $sources = [];

    /**
     * Image path hints by namespace.
     *
     * @var ImagePaths
     */
    protected $paths;

    /**
     * The image macros.
     *
     * @var ImageMacros
     */
    protected $macros;

    /**
     * The user agent utility.
     *
     * @var Mobile_Detect
     */
    protected $agent;

    /**
     * Create a new Image instance.
     *
     * @param Filesystem $files
     * @param Mobile_Detect $agent
     * @param Intervention $manager
     * @param Request $request
     * @param ImagePaths $paths
     * @param ImageMacros $macros
     */
    public function __construct(
        Mobile_Detect $agent,
        ImagePaths $paths,
        ImageMacros $macros
    ) {
        $this->agent       = $agent;
        $this->paths       = $paths;
        $this->macros      = $macros;
    }

    /**
     * Make a new image instance.
     *
     * @param  mixed $source
     * @return $this
     */
    public function make($source)
    {
        return new Image($source);
    }

    /**
     * Resolve a hinted path.
     *
     * @param string $path
     */
    public function resolve($path)
    {
        return $this->paths->resolve($path);
    }




    /**
     * Run a macro on the image.
     *
     * @param $macro
     * @return Image
     * @throws \Exception
     */
    public function macro($macro)
    {
        return $this->macros->run($macro, $this);
    }

    /**
     * Return a picture tag.
     *
     * @return string
     */
    public function picture(array $attributes = [])
    {
        $sources = [];

        $attributes = array_merge($this->getAttributes(), $attributes);

        /* @var Image $image */
        foreach ($this->getSources() as $media => $image) {
            if ($media != 'fallback') {
                $sources[] = $image->source();
            } else {
                $sources[] = $image->image();
            }
        }

        $sources = implode("\n", $sources);

        $attributes = $this->html->attributes($attributes);

        return "<picture {$attributes}>\n{$sources}\n</picture>";
    }

    /**
     * Return a source tag.
     *
     * @return string
     */
    public function source()
    {
        $this->addAttribute('srcset', $this->srcset() ?: $this->path() . ' 2x, ' . $this->path() . ' 1x');

        $attributes = $this->html->attributes($this->getAttributes());

        if ($srcset = $this->srcset()) {
            $attributes['srcset'] = $srcset;
        }

        return "<source {$attributes}>";
    }

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
     * Set the sources/alterations.
     *
     * @param  array $sources
     * @param  bool $merge
     * @return $this
     */
    public function sources(array $sources, $merge = true)
    {
        foreach ($sources as $media => &$alterations) {
            if ($merge) {
                $alterations = array_merge($this->getAlterations(), $alterations);
            }

            $image = $this->make(array_pull($alterations, 'image', $this->getImage()))->setOutput('source');

            if ($media != 'fallback') {
                call_user_func([$image, 'media'], $media);
            }

            foreach ($alterations as $method => $arguments) {
                if (is_array($arguments)) {
                    call_user_func_array([$image, $method], $arguments);
                } else {
                    call_user_func([$image, $method], $arguments);
                }
            }

            $alterations = $image;
        }

        $this->setSources($sources);

        return $this;
    }

    /**
     * Alter the image based on the user agents.
     *
     * @param  array $agents
     * @param  bool $exit
     * @return $this
     */
    public function agents(array $agents, $exit = false)
    {
        foreach ($agents as $agent => $alterations) {
            if (
                $this->agent->is($agent)
                || ($agent == 'phone' && $this->agent->isPhone())
                || ($agent == 'mobile' && $this->agent->isMobile())
                || ($agent == 'tablet' && $this->agent->isTablet())
                || ($agent == 'desktop' && $this->agent->isDesktop())
            ) {
                foreach ($alterations as $method => $arguments) {
                    if (is_array($arguments)) {
                        call_user_func_array([$this, $method], $arguments);
                    } else {
                        call_user_func([$this, $method], $arguments);
                    }
                }

                if ($exit) {
                    return $this;
                }
            }
        }

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

    /**
     * Get the sources.
     *
     * @return array
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Set the sources.
     *
     * @param  array $sources
     * @return $this
     */
    public function setSources(array $sources)
    {
        $this->sources = $sources;

        return $this;
    }

    /**
     * Add a path by it's namespace hint.
     *
     * @param $namespace
     * @param $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    /**
     * Return the output.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->output();
    }
}
