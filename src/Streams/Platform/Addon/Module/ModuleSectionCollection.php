<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Support\Collection;

class ModuleSectionCollection extends Collection
{
    /**
     * Return the active section.
     *
     * @return null
     */
    public function active()
    {
        foreach ($this->items as $section) {
            if (isset($section['path']) and str_contains(\Request::path(), $section['path'])) {
                return $section;
            }
        }

        return null;
    }
}