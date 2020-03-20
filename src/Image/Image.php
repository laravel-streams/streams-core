<?php

namespace Anomaly\Streams\Platform\Image;

/**
 * Class Image
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Image
{

    /**
     * The image source.
     *
     * @var mixed
     */
    protected $source;
    
    /**
     * The version flag.
     *
     * @var null|boolean
     */
    protected $version;

    /**
     * The output quality.
     *
     * @var null|int
     */
    protected $quality;

    /**
     * The file extension.
     *
     * @var null|string
     */
    protected $extension;

    /**
     * The desired filename.
     *
     * @var null|string
     */
    protected $filename;

    /**
     * The original filename.
     *
     * @var null|string
     */
    protected $original;

    /**
     * Applied alterations.
     *
     * @var array
     */
    protected $alterations = [];

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
     * Return the raw image data.
     *
     * @return string
     */
    public function data()
    {
        return app(ImageManager::class)->proxy($this->source)->data();
    }

    /**
     * Return if the Image is remote or not.
     *
     * @return bool
     */
    public function isRemote()
    {
        return is_string($this->source) && starts_with($this->source, ['http://', 'https://', '//']);
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function __toString() {
        return $this->data();
    }
}
