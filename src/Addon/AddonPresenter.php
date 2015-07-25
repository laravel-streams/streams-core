<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Support\Presenter;

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
     * The resource object.
     * This is for IDE hinting.
     *
     * @var Addon
     */
    protected $object;

    /**
     * Return the location wrapped in a label.
     *
     * @return string
     */
    public function locationLabel()
    {
        if ($this->object->isCore()) {
            return '<span class="label label-danger">' . trans('streams::addon.core') . '</span>';
        }

        if ($this->object->isShared()) {
            return '<span class="label label-success">' . trans('streams::addon.shared') . '</span>';
        }

        return '<span class="label label-warning">' . trans('streams::addon.private') . '</span>';
    }
}
