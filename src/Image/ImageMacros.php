<?php namespace Anomaly\Streams\Platform\Image;

use Illuminate\Config\Repository;

/**
 * Class ImageMacros
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Image
 */
class ImageMacros
{

    /**
     * Registered macros.
     *
     * @var array
     */
    protected $macros = [];

    /**
     * Create a new ImageMacros instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->macros = $config->get('streams::images.macros', []);
    }

    /**
     * Get the macros.
     *
     * @return array|mixed
     */
    public function getMacros()
    {
        return $this->macros;
    }

    /**
     * Set the macros.
     *
     * @param array $macros
     * @return $this
     */
    public function setMacros(array $macros)
    {
        $this->macros = $macros;

        return $this;
    }

    /**
     * Add an image macro hint.
     *
     * @param $namespace
     * @param $macro
     * @return $this
     */
    public function addMacro($namespace, $macro)
    {
        $this->macros[$namespace] = $macro;

        return $this;
    }

    /**
     * Run a macro.
     *
     * @param       $macro
     * @param Image $image
     * @return Image
     * @throws \Exception
     */
    public function run($macro, Image $image)
    {
        if (!$macro = array_get($this->getMacros(), $macro)) {
            throw new \Exception("The {$macro} image macro does not exist.");
        }

        return $image;
    }
}
