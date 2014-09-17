<?php namespace Streams\Core\Addon\Collection;

use Streams\Core\Support\Collection;

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