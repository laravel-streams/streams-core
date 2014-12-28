<?php namespace Anomaly\Streams\Platform\Addon;

use Robbo\Presenter\Presenter;

/**
 * Class AddonPresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonPresenter extends Presenter
{

    /**
     * Return the translated addon name.
     *
     * @return string
     */
    public function name()
    {
        return trans($this->object->getName());
    }

    /**
     * Return the translated addon description.
     *
     * @return string
     */
    public function description()
    {
        return trans($this->object->getDescription());
    }
}
