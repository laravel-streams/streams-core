<?php

namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\AddonPresenter;

/**
 * Class ThemePresenter.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme
 */
class ThemePresenter extends AddonPresenter
{
    /**
     * The decorated object.
     * This is for IDE hinting.
     *
     * @var Theme
     */
    protected $object;

    /**
     * Return the state wrapped in a label.
     *
     * @return string
     */
    public function activeLabel()
    {
        if ($this->object->isActive()) {
            return '<span class="label label-success">'.trans('streams::addon.active').'</span>';
        }
    }

    /**
     * Return the type name.
     *
     * @return string
     */
    public function themeType()
    {
        if ($this->object->isAdmin()) {
            return trans('streams::addon.admin');
        }

        return trans('streams::addon.public');
    }
}
