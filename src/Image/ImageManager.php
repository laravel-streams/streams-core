<?php

namespace Anomaly\Streams\Platform\Image;

use Mobile_Detect;
use Illuminate\Http\Request;
use Collective\Html\HtmlBuilder;
use Intervention\Image\ImageManager as Intervention;
use Illuminate\Filesystem\Filesystem;
use Anomaly\Streams\Platform\Application\Application;

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
     * The publish flag.
     *
     * @var bool
     */
    protected $publish = false;

    /**
     * The image object.
     *
     * @var null|string
     */
    protected $image = null;

    /**
     * The file extension.
     *
     * @var null|string
     */
    protected $extension = null;

    /**
     * The desired filename.
     *
     * @var null|string
     */
    protected $filename = null;

    /**
     * The original filename.
     *
     * @var null|string
     */
    protected $original = null;

    /**
     * The image attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Applied alterations.
     *
     * @var array
     */
    protected $alterations = [];

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
     * Allowed methods.
     *
     * @var array
     */
    protected $allowedMethods = [
        'blur',
        'brightness',
        'colorize',
        'resizeCanvas',
        'contrast',
        'copy',
        'crop',
        'fit',
        'flip',
        'gamma',
        'greyscale',
        'heighten',
        'insert',
        'interlace',
        'invert',
        'limitColors',
        'pixelate',
        'opacity',
        'resize',
        'rotate',
        'amount',
        'widen',
        'orientate',
        'text',
    ];

    /**
     * The quality of the output.
     *
     * @var null|int
     */
    protected $quality = null;

    /**
     * The image width.
     *
     * @var null|int
     */
    protected $width = null;

    /**
     * The image height.
     *
     * @var null|int
     */
    protected $height = null;

    /**
     * The copy mode flag.
     *
     * @var bool
     */
    protected $copy = false;

    /**
     * The HTML builder.
     *
     * @var HtmlBuilder
     */
    protected $html;

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
     * The file system.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The user agent utility.
     *
     * @var Mobile_Detect
     */
    protected $agent;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The image manager.
     *
     * @var Intervention
     */
    protected $manager;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Image instance.
     *
     * @param HtmlBuilder $html
     * @param Filesystem $files
     * @param Mobile_Detect $agent
     * @param Intervention $manager
     * @param Request $request
     * @param Application $application
     * @param ImagePaths $paths
     * @param ImageMacros $macros
     */
    public function __construct(
        HtmlBuilder $html,
        Filesystem $files,
        Mobile_Detect $agent,
        Intervention $manager,
        Request $request,
        Application $application,
        ImagePaths $paths,
        ImageMacros $macros
    ) {
        $this->html        = $html;
        $this->files       = $files;
        $this->agent       = $agent;
        $this->paths       = $paths;
        $this->macros      = $macros;
        $this->manager     = $manager;
        $this->request     = $request;
        $this->application = $application;
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
     * Return the asset path to an image.
     *
     * @return string
     */
    public function asset()
    {
        $path = $this->getCachePath();

        return url()->asset($path);
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
     * Return the URL to an image.
     *
     * @param  array $parameters
     * @param  null $secure
     * @return string
     */
    public function url(array $parameters = [], $secure = null)
    {
        return url()->asset($this->getCachePath(), $parameters, $secure);
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

        return $this->image($alt, $attributes);
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
        $extension = $this->getExtension();

        if ($extension == 'svg') {
            $extension = 'svg+xml';
        }

        return 'data:image/' . $extension . ';base64,' . base64_encode($this->data());
    }

    /**
     * Return the output.
     *
     * @return string
     */
    public function output()
    {
        return $this->img();
    }

    /**
     * Set the quality.
     *
     * @param $quality
     * @return $this
     */
    public function quality($quality)
    {
        return $this->setQuality($quality);
    }

    /**
     * Set the width attribute.
     *
     * @param  null $width
     * @return Image
     */
    public function width($width = null)
    {
        return $this->addAttribute('width', $width ?: $this->getWidth());
    }

    /**
     * Set the height attribute.
     *
     * @param  null $height
     * @return Image
     */
    public function height($height = null)
    {
        return $this->addAttribute('height', $height ?: $this->getHeight());
    }

    /**
     * Set the quality.
     *
     * @param $quality
     * @return $this
     */
    public function setQuality($quality)
    {
        $this->quality = (int) $quality;

        return $this;
    }

    /**
     * Set an attribute value.
     *
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function attr($attribute, $value)
    {
        array_set($this->attributes, $attribute, $value);

        return $this;
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
     * Read an image instance's data.
     *
     * @return string
     */
    protected function read($source)
    {
        // if ($source instanceof FileInterface) {
        //     return app('League\Flysystem\MountManager')->read($source->location());
        // }

        if (is_string($source) && str_is('*::*', $source)) {
            return file_get_contents($this->resolve($source));
        }

        if (is_string($source) && str_is('*://*', $source) && !starts_with($source, ['http', '//'])) {
            return app('League\Flysystem\MountManager')->read($source);
        }
        
        if (is_string($source) && (file_exists($source) || starts_with($source, ['http', '//']))) {
            return file_get_contents($source);
        }

        if (is_string($source) && file_exists($source)) {
            return file_get_contents($source);
        }

        if ($source instanceof File) {
            return $source->read();
        }

        if ($source instanceof ImageManager) {
            return $source->encode();
        }

        if (is_string($source) && file_exists($source)) {
            return file_get_contents($source);
        }

        return null;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the attributes.
     *
     * @param  array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Add an attribute.
     *
     * @param  $attribute
     * @param  $value
     * @return $this
     */
    protected function addAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

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
     * Get the quality.
     *
     * @return int|null
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * Get the allowed methods.
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return $this->allowedMethods;
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
     * Get the width.
     *
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the width.
     *
     * @param $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the height.
     *
     * @return int|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the height.
     *
     * @param $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

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

    /**
     * If the method does not exist then
     * add an attribute and return.
     *
     * @param $name
     * @param $arguments
     * @return $this|mixed
     */
    public function __call($name, $arguments)
    {
        if (in_array($name, $this->getAllowedMethods())) {
            return $this->addAlteration($name, $arguments);
        }

        if ($this->macros->isMacro($macro = snake_case($name))) {
            return $this->macro($macro);
        }

        if (!method_exists($this, $name)) {
            array_set($this->attributes, $name, array_shift($arguments));

            return $this;
        }

        return call_user_func_array([$this, $name], $arguments);
    }
}
