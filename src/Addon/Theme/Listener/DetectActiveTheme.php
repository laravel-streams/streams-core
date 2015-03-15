<?php namespace Anomaly\Streams\Platform\Addon\Theme\Listener;

use Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

/**
 * Class DetectActiveTheme
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Listener
 */
class DetectActiveTheme
{

    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new DetectActiveTheme instance.
     *
     * @param Asset      $asset
     * @param Image      $image
     * @param Request    $request
     * @param Repository $config
     */
    public function __construct(
        Asset $asset,
        Image $image,
        Request $request,
        Repository $config
    ) {
        $this->asset   = $asset;
        $this->image   = $image;
        $this->config  = $config;
        $this->request = $request;
    }

    /**
     * Detect the active theme and set up
     * our environment with it.
     */
    public function handle()
    {
        if (in_array($this->request->segment(1), ['installer', 'admin'])) {
            $theme = $this->config->get('streams.admin_theme');
        } else {
            $theme = $this->config->get('streams.standard_theme');
        }

        $theme = app($theme);

        if ($theme instanceof Theme) {

            $theme->setActive(true);

            app('view')->addNamespace('theme', $theme->getPath('resources/views'));
            app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));

            $this->asset->addPath('theme', $theme->getPath('resources'));
            $this->image->addPath('theme', $theme->getPath('resources'));
        }
    }
}
