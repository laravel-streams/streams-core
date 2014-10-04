<?php namespace Streams\Platform\Addon\Theme;

use Streams\Platform\Addon\AddonTranslator;

class ThemeTranslator extends AddonTranslator
{
    /**
     * Translate a module to it's tag.


*
*@param ThemeAddon $theme
     * @return bool|string
     */
    public function toTag(ThemeAddon $theme)
    {
        return $this->translate($theme, 'Tag');
    }
}
 