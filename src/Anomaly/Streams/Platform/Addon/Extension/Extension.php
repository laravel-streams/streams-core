<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

/**
 * Class Extension
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
class Extension extends Addon implements PresentableInterface
{

    /**
     * Expedite this extension
     * if used in a collection.
     *
     * @var bool
     */
    protected $expedited = false;

    /**
     * Defer this extension
     *if used in a collection.
     *
     * @var bool
     */
    protected $deferred = false;

    /**
     * Return deferred flag.
     *
     * @return boolean
     */
    public function isDeferred()
    {
        return ($this->deferred);
    }

    /**
     * Return the expedited flag.
     *
     * @return boolean
     */
    public function isExpedited()
    {
        return ($this->expedited);
    }

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
