<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\AddonTranslator;

class ThemeTranslator extends AddonTranslator
{
    /**
     * Translate a module to it's tag.
     *
     * @param ThemeAbstract $theme
     * @return bool|string
     */
    public function toTag(ThemeAbstract $theme)
    {
        return $this->translate($theme, 'Tag');
    }
}
 