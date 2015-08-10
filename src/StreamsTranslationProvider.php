<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\Command\RegisterAddons;
use Anomaly\Streams\Platform\Application\Command\AddTwigExtensions;
use Anomaly\Streams\Platform\Application\Command\ConfigureCommandBus;
use Anomaly\Streams\Platform\Application\Command\ConfigureTranslator;
use Anomaly\Streams\Platform\Application\Command\InitializeApplication;
use Anomaly\Streams\Platform\Application\Command\LoadStreamsConfiguration;
use Anomaly\Streams\Platform\Application\Command\SetCoreConnection;
use Anomaly\Streams\Platform\Asset\Command\AddAssetNamespaces;
use Anomaly\Streams\Platform\Entry\Command\AutoloadEntryModels;
use Anomaly\Streams\Platform\Image\Command\AddImageNamespaces;
use Anomaly\Streams\Platform\View\Command\AddViewNamespaces;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;

/**
 * Class StreamsTranslationProvider
 *
 * In order to consolidate service providers throughout the
 * Streams Platform, we do all of our bootstrapping here.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform
 */
class StreamsTranslationProvider extends ServiceProvider
{

    use DispatchesJobs;

    /**
     * Boot the service provider.
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
