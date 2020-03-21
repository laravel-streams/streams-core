<?php

namespace Anomaly\Streams\Platform\Image;

use Anomaly\Streams\Platform\Image\Concerns\CanOutput;
use Anomaly\Streams\Platform\Image\Concerns\HasSource;
use Anomaly\Streams\Platform\Image\Concerns\CanPublish;
use Anomaly\Streams\Platform\Image\Concerns\HasVersion;
use Anomaly\Streams\Platform\Image\Concerns\HasFilename;
use Anomaly\Streams\Platform\Image\Concerns\HasExtension;
use Anomaly\Streams\Platform\Image\Concerns\HasAlterations;
use Anomaly\Streams\Platform\Image\Concerns\HasQuality;

/**
 * Class Image
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Image
{

    use HasSource;
    use HasQuality;
    use HasVersion;
    use HasFilename;
    use HasExtension;
    use HasAlterations;
    
    use CanOutput;
    use CanPublish;

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
     * Undocumented function
     *
     * @return string
     */
    public function __toString() {
        return $this->data();
    }
}
