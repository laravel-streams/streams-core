<?php namespace Anomaly\Streams\Platform\Config\Support;

use Anomaly\SelectFieldType\SelectFieldType;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;

/**
 * Class StandardThemeOptions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StandardThemeOptions
{

    /**
     * Handle the options.
     *
     * @param SelectFieldType $fieldType
     * @param ThemeCollection $themes
     */
    public function handle(SelectFieldType $fieldType, ThemeCollection $themes)
    {
        $fieldType->setOptions($themes->standard()->pluck('title', 'namespace')->all());
    }
}
