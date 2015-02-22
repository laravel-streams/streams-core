<?php namespace Anomaly\Streams\Platform\Addon\Theme\Command\Handler;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;

/**
 * Class DetectActiveThemeHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Theme\Command
 */
class DetectActiveThemeHandler
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
     * The settings repository.
     *
     * @var SettingRepositoryInterface
     */
    protected $settings;

    /**
     * The loaded distributions.
     *
     * @var \Anomaly\Streams\Platform\Addon\Distribution\DistributionCollection
     */
    protected $distributions;

    /**
     * Create a new DetectActiveThemeHandler instance.
     *
     * @param Asset                      $asset
     * @param Image                      $image
     * @param SettingRepositoryInterface $settings
     * @param DistributionCollection     $distributions
     */
    public function __construct(
        Asset $asset,
        Image $image,
        SettingRepositoryInterface $settings,
        DistributionCollection $distributions
    ) {
        $this->asset         = $asset;
        $this->image         = $image;
        $this->settings      = $settings;
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
                $theme = $this->settings->get('streams::admin_theme', env('ADMIN_THEME'));
            } else {
                $theme = $this->settings->get('streams::standard_theme', env('STANDARD_THEME'));
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
