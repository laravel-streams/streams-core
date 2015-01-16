<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Block\Block;
use Anomaly\Streams\Platform\Addon\Block\Event\BlockWasRegistered;
use Anomaly\Streams\Platform\Addon\Distribution\Distribution;
use Anomaly\Streams\Platform\Addon\Distribution\Event\DistributionWasRegistered;
use Anomaly\Streams\Platform\Addon\Event\AddonWasRegistered;
use Anomaly\Streams\Platform\Addon\Extension\Event\ExtensionWasRegistered;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\FieldType\Event\FieldTypeWasRegistered;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasRegistered;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Plugin\Event\PluginWasRegistered;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Addon\Theme\Event\ThemeWasRegistered;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Illuminate\Events\Dispatcher;

/**
 * Class AddonDispatcher
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonDispatcher
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Create a new AddonDispatcher instance.
     *
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Disperse the AddonWasRegistered event.
     *
     * @param Addon $addon
     */
    public function addonWasRegistered(Addon $addon)
    {
        $this->dispatcher->fire(new AddonWasRegistered($addon));

        if ($addon instanceof Block) {
            $this->dispatcher->fire(new BlockWasRegistered($addon));
        }

        if ($addon instanceof Distribution) {
            $this->dispatcher->fire(new DistributionWasRegistered($addon));
        }

        if ($addon instanceof Extension) {
            $this->dispatcher->fire(new ExtensionWasRegistered($addon));
        }

        if ($addon instanceof FieldType) {
            $this->dispatcher->fire(new FieldTypeWasRegistered($addon));
        }

        if ($addon instanceof Module) {
            $this->dispatcher->fire(new ModuleWasRegistered($addon));
        }

        if ($addon instanceof Plugin) {
            $this->dispatcher->fire(new PluginWasRegistered($addon));
        }

        if ($addon instanceof Theme) {
            $this->dispatcher->fire(new ThemeWasRegistered($addon));
        }
    }
}
