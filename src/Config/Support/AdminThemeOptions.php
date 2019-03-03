<?php namespace Anomaly\Streams\Platform\Config\Support;

use Anomaly\SelectFieldType\SelectFieldType;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;

/**
 * Class AdminThemeOptions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AdminThemeOptions
{

    /**
     * Handle the options.
     *
     * @param SelectFieldType $fieldType
     * @param ThemeCollection $themes
     */
    public function handle(SelectFieldType $fieldType, ThemeCollection $themes)
    {
        $fieldType->setOptions($themes->admin()->pluck('title', 'namespace')->all());
    }
}
