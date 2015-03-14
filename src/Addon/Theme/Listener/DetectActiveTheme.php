<?php namespace Anomaly\Streams\Platform\Addon\Theme\Listener;

use Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Illuminate\Config\Repository;

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
     * The loaded distributions.
     *
     * @var \Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection
     */
    protected $distributions;

    /**
     * Create a new DetectActiveTheme instance.
     *
     * @param Asset                  $asset
     * @param Image                  $image
     * @param Repository             $config
     * @param DistributionCollection $distributions
     */
    public function __construct(
        Asset $asset,
        Image $image,
        Repository $config,
        DistributionCollection $distributions
    ) {
        $this->asset         = $asset;
        $this->image         = $image;
        $this->config        = $config;
        $this->distributions = $distributions;
    }

    /**
     * Detect the active theme and set up
     * our environment with it.
     */
    public function handle()
    {
        if ($distribution = $this->distributions->active()) {

            if (app('request')->segment(1) == 'admin' || app('request')->segment(1) == 'installer') {
                $theme = env('ADMIN_THEME', $distribution->getAdminTheme());
            } else {
                $theme = env('STANDARD_THEME', $distribution->getStandardTheme());
            }

            $theme = app($theme);

            if ($theme instanceof Theme) {

                $theme->setActive(true);

                app('view')->addNamespace('theme', $theme->getPath('resources/views'));
                app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));

                $this->asset->addNamespace('theme', $theme->getPath('resources'));
                $this->image->addNamespace('theme', $theme->getPath('resources'));
            }
        }
    }
}
