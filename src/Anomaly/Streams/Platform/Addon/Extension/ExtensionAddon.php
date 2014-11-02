<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

/**
 * Class ExtensionAddon
 *
 * This is the default authenticator for the Users module.
 * Extensions generally return a handler to do their business
 * through transformer methods but can utilize any pattern.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionAddon extends Addon implements PresentableInterface
{

    /**
     * Return a decorated addon.
     *
     * @return ExtensionPresenter
     */
    public function decorate()
    {
        return new ExtensionPresenter($this);
    }
}
